<?php
require('../../database/connection/connection.php');

// Get Project ID from URL
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($project_id <= 0) {
    die("Invalid Project ID.");
}

/**
 * Converts numbers to shorthand strings (K, M, B, T)
 */
function formatShorthand($n) {
    if ($n >= 1000000000000) return round($n / 1000000000000, 2) . 'T';
    if ($n >= 1000000000) return round($n / 1000000000, 2) . 'B';
    if ($n >= 1000000) return round($n / 1000000, 2) . 'M';
    if ($n >= 1000) return round($n / 1000, 2) . 'K';
    return number_format($n);
}

try {
    // 1. Fetch Main Project, Details, and Contractor Name
    $sql = "SELECT p.*, pd.*, c.Contractor_Name 
            FROM projects_table p
            INNER JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
            LEFT JOIN contractor_table c ON p.Contractor_ID = c.Contractor_Id
            WHERE p.Project_ID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $project_id);
    $stmt->execute();
    $project = $stmt->get_result()->fetch_assoc();

    if (!$project) {
        die("Project not found.");
    }

    // 2. Fetch Milestone Gallery (Photos)
    $stmtMs = $conn->prepare("SELECT projectMilestone_Image_Path, projectMilestone_Phase, projectMilestone_UploadedAT 
                             FROM projectmilestone_table 
                             WHERE Project_ID = ? 
                             ORDER BY projectMilestone_UploadedAT DESC");
    $stmtMs->bind_param("i", $project_id);
    $stmtMs->execute();
    $milestones = $stmtMs->get_result()->fetch_all(MYSQLI_ASSOC);

    // 3. Fetch Documents
    $stmtDoc = $conn->prepare("SELECT * FROM projectsdocument_table WHERE Project_ID = ?");
    $stmtDoc->bind_param("i", $project_id);
    $stmtDoc->execute();
    $documents = $stmtDoc->get_result()->fetch_all(MYSQLI_ASSOC);

    // 4. Construct Full Address
    $full_address = $project['ProjectDetails_Street'] . ', ' . 
                    $project['ProjectDetails_Barangay'] . ', ' . 
                    $project['ProjectDetails_ZIP_Code'];

} catch (mysqli_sql_exception $e) {
    die("Database Error: " . $e->getMessage());
}
?>