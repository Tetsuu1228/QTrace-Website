<?php
// Database connection
require('../../database/connection/connection.php');

// Check if this is being called as API or included as view
$is_api_call = !isset($return_data_only);
$return_data_only = true; // Flag to return data only

// Set content type to JSON only if API call
if ($is_api_call) {
    header('Content-Type: application/json');
}

// Start session for authentication check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// TODO: Authentication check - ensure user is logged in
// if (!isset($_SESSION['user_id'])) {
//     http_response_code(401);
//     echo json_encode(['error' => 'Unauthorized: Please log in']);
//     exit;
// }

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        // Sanitize and validate pagination parameters
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = isset($_GET['limit']) ? min(100, max(1, (int)$_GET['limit'])) : 20;
        $offset = ($page - 1) * $limit;

        // Initialize filter conditions
        $where_conditions = [];
        $params = [];
        $param_types = '';

        // Filter by status (optional)
        if (!empty($_GET['status'])) {
            $where_conditions[] = "pt.Project_Status = ?";
            $params[] = trim($_GET['status']);
            $param_types .= 's';
        }

        // Filter by contractor (optional)
        if (!empty($_GET['contractor_id'])) {
            $where_conditions[] = "pt.Contractor_ID = ?";
            $params[] = (int)$_GET['contractor_id'];
            $param_types .= 'i';
        }

        // Search by project title or description (optional)
        if (!empty($_GET['search'])) {
            $search_term = '%' . trim($_GET['search']) . '%';
            $where_conditions[] = "(pt.Project_Title LIKE ? OR pt.Project_Description LIKE ?)";
            $params[] = $search_term;
            $params[] = $search_term;
            $param_types .= 'ss';
        }

        // Build WHERE clause
        $where_clause = '';
        if (!empty($where_conditions)) {
            $where_clause = 'WHERE ' . implode(' AND ', $where_conditions);
        }

        // Get total count for pagination metadata
        $count_sql = "SELECT COUNT(*) as total FROM projects_table pt $where_clause";
        $count_stmt = $conn->prepare($count_sql);
        if (!empty($params)) {
            $refs = [];
            foreach ($params as $key => $value) {
                $refs[$key] = &$params[$key];
            }
            $count_stmt->bind_param($param_types, ...$refs);
        }
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        $total_records = $count_result->fetch_assoc()['total'];
        $count_stmt->close();

        // Fetch paginated project list with selected columns
        $sql = "SELECT 
                    pt.Project_Id,
                    pt.Project_Title,
                    pt.Project_Description,
                    pt.Contractor_ID,
                    pt.Project_Budget,
                    pt.Project_StartedDate,
                    pt.Project_EndDate,
                    pt.Project_Status,
                    pt.Location_ID
                FROM projects_table pt
                $where_clause
                ORDER BY pt.Project_Id DESC
                LIMIT ? OFFSET ?";

        $stmt = $conn->prepare($sql);
        // Merge all parameters with pagination
        $all_params = array_merge($params, [$limit, $offset]);
        $all_types = $param_types . 'ii';
        
        // Use call_user_func_array with proper reference binding
        if (!empty($all_params)) {
            $refs = [];
            foreach ($all_params as $key => $value) {
                $refs[$key] = &$all_params[$key];
            }
            $stmt->bind_param($all_types, ...$refs);
        }

        if (!$stmt->execute()) {
            throw new Exception("Query execution failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $project_lists = [];

        while ($row = $result->fetch_assoc()) {
            $project_lists[] = $row;
        }

        $stmt->close();

        // Return paginated response with metadata
        $response = [
            'success' => true,
            'data' => $project_lists,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total_records' => $total_records,
                'total_pages' => ceil($total_records / $limit)
            ]
        ];

        // If called as API, return JSON; otherwise return data array
        if ($is_api_call) {
            echo json_encode($response);
        } else {
            // Return data for use in included file
            return $response;
        }

    } catch (Exception $e) {
        $error_response = [
            'error' => 'Database error occurred',
            'message' => $e->getMessage()
        ];
        
        if ($is_api_call) {
            http_response_code(500);
            echo json_encode($error_response);
        } else {
            return $error_response;
        }
    }
} else {
    $error_response = ['error' => 'Method Not Allowed'];
    
    if ($is_api_call) {
        http_response_code(405);
        echo json_encode($error_response);
    } else {
        return $error_response;
    }
}
?>