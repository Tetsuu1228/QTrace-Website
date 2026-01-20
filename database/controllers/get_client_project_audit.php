<?php
// Database connection
require('../../database/connection/connection.php');

try {
    // 1. Collect filter values from GET request
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $actionFilter = isset($_GET['action']) ? trim($_GET['action']) : '';

    // 2. Pagination settings
    $records_per_page = 10;
    $results_per_page = $records_per_page;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $records_per_page;
    $start_from = ($page - 1) * $records_per_page;

    // 3. Base SQL Query for counting - ONLY PROJECT AUDITS
    $countSql = "SELECT COUNT(*) as total
                FROM audit_logs a
                LEFT JOIN user_table u ON a.user_id = u.user_ID
                WHERE a.resource_type = 'Project'";

    // 4. Build dynamic WHERE clauses
    $whereClauses = [];
    $params = [];
    $types = "";

    // If search is not empty, search by project title from new_values JSON
    if ($search !== '') {
        // We'll search in the new_values JSON for Project_Title
        $whereClauses[] = "(a.new_values LIKE ? OR a.old_values LIKE ?)";
        $searchParam = "%\"Project_Title\":\"%" . $search . "%\"%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "ss";
    }

    // If an action is selected
    if ($actionFilter !== '') {
        $whereClauses[] = "a.action = ?";
        $params[] = $actionFilter;
        $types .= "s";
    }

    // Attach WHERE clauses to count query
    if (!empty($whereClauses)) {
        $countSql .= " AND " . implode(" AND ", $whereClauses);
    }

    // Get total records count
    $stmtCount = $conn->prepare($countSql);
    if (!empty($params)) {
        $stmtCount->bind_param($types, ...$params);
    }
    $stmtCount->execute();
    $totalResult = $stmtCount->get_result();
    $totalRow = $totalResult->fetch_assoc();
    $total_records = $totalRow['total'];
    $total_pages = ceil($total_records / $records_per_page);

    // 5. Base SQL Query for data - ONLY PROJECT AUDITS
    $sql = "SELECT 
                a.audit_log_id, 
                a.user_id, 
                a.action, 
                a.resource_type, 
                a.resource_id, 
                a.old_values, 
                a.new_values, 
                a.created_at,
                u.user_firstName,
                u.user_lastName
            FROM audit_logs a
            LEFT JOIN user_table u ON a.user_id = u.user_ID
            WHERE a.resource_type = 'Project'";

    // Attach WHERE clauses to main query
    if (!empty($whereClauses)) {
        $sql .= " AND " . implode(" AND ", $whereClauses);
    }

    // Add Ordering and Pagination
    $sql .= " ORDER BY a.created_at DESC LIMIT ? OFFSET ?";

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);
    $stmtLimitOffset = $stmt;
    
    if (!empty($params)) {
        // Add pagination parameters
        $params[] = $records_per_page;
        $params[] = $offset;
        $types .= "ii";
        
        $stmtLimitOffset->bind_param($types, ...$params);
    } else {
        $stmtLimitOffset->bind_param("ii", $records_per_page, $offset);
    }

    $stmtLimitOffset->execute();
    $result = $stmtLimitOffset->get_result();

    // Helper function to extract JSON values
    function getProjectInfo($jsonString) {
        if (!$jsonString) return null;
        try {
            $data = json_decode($jsonString, true);
            return $data;
        } catch (Exception $e) {
            return null;
        }
    }

    // Helper function to format currency
    function formatCurrency($value) {
        if (!$value) return '₱0.00';
        return '₱' . number_format($value, 2);
    }

    // Helper function to format date
    function formatDate($dateString) {
        if (!$dateString) return 'N/A';
        return date('M d, Y \a\t h:i A', strtotime($dateString));
    }

} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    $result = null;
}
?>
