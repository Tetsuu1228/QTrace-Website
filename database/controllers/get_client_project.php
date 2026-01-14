<?php
require('../../database/connection/connection.php');

// 1. Get Filter/Search Inputs
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';

// 2. Build the Relational Query
$sql = "SELECT p.*, pd.* FROM projects_table p
        INNER JOIN projectdetails_table pd ON p.Project_ID = pd.Project_ID
        WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (pd.ProjectDetails_Title LIKE '%$search%' 
               OR pd.ProjectDetails_Description LIKE '%$search%')";
}

if (!empty($status)) {
    $sql .= " AND p.Project_Status = '$status'";
}

if (!empty($category)) {
    $sql .= " AND p.Project_Category = '$category'";
}

$sql .= " ORDER BY p.Project_ID DESC";
$result = $conn->query($sql);

/**
 * Helper function for shorthand currency (K, M, B)
 */
function formatShorthand($n) {
    if ($n >= 1000000000) return round($n / 1000000000, 2) . 'B';
    if ($n >= 1000000) return round($n / 1000000, 2) . 'M';
    if ($n >= 1000) return round($n / 1000, 2) . 'K';
    return number_format($n);
}
?>