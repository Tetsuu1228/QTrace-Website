<?php
require('../../database/connection/connection.php');

try {
    // 1. Store the query string in a variable named $sql
    $sql = "SELECT 
                p.Project_ID,
                p.Contractor_ID,
                p.Project_Status,
                p.Project_Category,
                p.Project_Lng,
                p.Project_Lat,
                pd.ProjectDetails_Title,
                pd.ProjectDetails_Description,
                pd.ProjectDetails_Budget,
                pd.ProjectDetails_Street,
                pd.ProjectDetails_Barangay,
                pd.ProjectDetails_ZIP_Code,
                pd.ProjectDetails_StartedDate,
                pd.ProjectDetails_EndDate
            FROM projects_table p
            INNER JOIN projectdetails_table pd 
            ON p.Project_ID = pd.Project_ID";
    
    // 2. Execute the query using the $conn variable from your connection.php
    $result = $conn->query($sql);

    // 3. Fetch the data
    $projects = $result->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    // Fallback to empty array if query fails so JS doesn't break
    $projects = [];
    // Optional: Log error for debugging
    // error_log($e->getMessage());
}
?>