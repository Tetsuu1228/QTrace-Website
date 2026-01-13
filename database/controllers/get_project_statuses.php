<?php
require('../../database/connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare and Execute Query to fetch all project statuses
    $sql = "SELECT * FROM project_status";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all rows
    if ($result->num_rows > 0) {
        $statuses = [];
        while ($row = $result->fetch_assoc()) {
            $statuses[] = $row;
        }
        echo json_encode($statuses);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}
?>