<?php
require('../../database/connection/connection.php');
/**
     * Format a datetime string into a relative phrase (e.g., "2 hours ago").
     */
    function formatTimeAgo($datetime) {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60) return 'Just now';
        if ($diff < 3600) {
            $m = floor($diff / 60);
            return $m . ' minute' . ($m === 1 ? '' : 's') . ' ago';
        }
        if ($diff < 86400) {
            $h = floor($diff / 3600);
            return $h . ' hour' . ($h === 1 ? '' : 's') . ' ago';
        }

        return date('M d, Y g:i A', $timestamp);
    }

    /**
     * Fetch parent reports and their admin comments for the current project.
     */
    $reports = [];
    $adminCommentsByReport = [];

    if ($project_id > 0) {
        $reportSql = "SELECT 
                        r.report_ID,
                        r.Project_ID,
                        r.user_ID,
                        r.report_type,
                        r.report_description,
                        r.report_evidencesPhoto_URL,
                        r.report_status,
                        r.report_CreatedAt,
                        u.user_firstName AS FirstName,
                        u.user_lastName AS LastName,
                        u.user_Role,
                        (SELECT COUNT(*) FROM report_table WHERE reportParent_ID = r.report_ID) AS message_count,
                        (SELECT MAX(report_CreatedAt) FROM report_table WHERE reportParent_ID = r.report_ID) AS last_message_time
                    FROM report_table r
                    LEFT JOIN user_table u ON r.user_ID = u.user_ID
                    WHERE r.Project_ID = ? AND r.reportParent_ID IS NULL
                    ORDER BY COALESCE(last_message_time, r.report_CreatedAt) DESC";

        $stmtReports = $conn->prepare($reportSql);
        $stmtReports->bind_param("i", $project_id);
        $stmtReports->execute();
        $resultReports = $stmtReports->get_result();

        $reportIDs = [];
        while ($row = $resultReports->fetch_assoc()) {
            $row['username'] = trim($row['FirstName'] . ' ' . $row['LastName']);
            $row['last_activity'] = $row['last_message_time'] ?? $row['report_CreatedAt'];
            $reports[] = $row;
            $reportIDs[] = (int) $row['report_ID'];
        }
        $stmtReports->close();

        if (!empty($reportIDs)) {
            $placeholders = implode(',', array_fill(0, count($reportIDs), '?'));
            $types = str_repeat('i', count($reportIDs));

            $adminSql = "SELECT 
                            r.report_ID,
                            r.reportParent_ID,
                            r.report_description,
                            r.report_evidencesPhoto_URL,
                            r.report_CreatedAt,
                            u.user_firstName AS FirstName,
                            u.user_lastName AS LastName
                        FROM report_table r
                        LEFT JOIN user_table u ON r.user_ID = u.user_ID
                        WHERE r.reportParent_ID IN ($placeholders) AND u.user_Role = 'admin'
                        ORDER BY r.report_CreatedAt DESC";

            $stmtAdmin = $conn->prepare($adminSql);
            $stmtAdmin->bind_param($types, ...$reportIDs);
            $stmtAdmin->execute();
            $resultAdmin = $stmtAdmin->get_result();

            while ($row = $resultAdmin->fetch_assoc()) {
                $parentID = (int) $row['reportParent_ID'];
                if (!isset($adminCommentsByReport[$parentID])) {
                    $adminCommentsByReport[$parentID] = [];
                }
                $adminCommentsByReport[$parentID][] = [
                    'author' => trim($row['FirstName'] . ' ' . $row['LastName']),
                    'message' => $row['report_description'],
                    'attachment' => $row['report_evidencesPhoto_URL'],
                    'created_at' => $row['report_CreatedAt']
                ];
            }

            $stmtAdmin->close();
        }
    }

?>