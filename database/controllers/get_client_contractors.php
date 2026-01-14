<?php
require('../../database/connection/connection.php');

// 1. Get Filter/Search Inputs
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$min_years = isset($_GET['min_years']) ? (int)$_GET['min_years'] : 0;

// 2. Build the Relational Query
// Joins contractor with their expertise
$sql = "SELECT c.*, GROUP_CONCAT(e.Expertise SEPARATOR ', ') as skills 
        FROM contractor_table c
        LEFT JOIN contractor_expertise_table e ON c.Contractor_Id = e.Contractor_Id
        WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (c.Contractor_Name LIKE '%$search%' 
               OR c.Owner_Name LIKE '%$search%'
               OR c.Contractor_Id IN (SELECT Contractor_Id FROM contractor_expertise_table WHERE Expertise LIKE '%$search%'))";
}

if ($min_years > 0) {
    $sql .= " AND c.Years_Of_Experience >= $min_years";
}

$sql .= " GROUP BY c.Contractor_Id ORDER BY c.Years_Of_Experience DESC";
$result = $conn->query($sql);
?>