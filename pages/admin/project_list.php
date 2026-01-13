<?php 
    $current_page = 'projectList';
    
    // Session and authentication
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Simulate GET parameters for the controller
    $_GET['page'] = isset($_GET['page']) ? $_GET['page'] : 1;
    $_GET['limit'] = isset($_GET['limit']) ? $_GET['limit'] : 10;
    $_GET['status'] = isset($_GET['status']) ? $_GET['status'] : '';
    $_GET['contractor_id'] = isset($_GET['contractor_id']) ? $_GET['contractor_id'] : '';
    $_GET['search'] = isset($_GET['search']) ? $_GET['search'] : '';
    $_SERVER['REQUEST_METHOD'] = 'GET';
    
    // Call controller to get data
    $return_data_only = true;
    $result = require('../../database/controllers/get_projectlists.php');
    
    $projects = $result['data'] ?? [];
    $pagination = $result['pagination'] ?? [];
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content="List of projects on Quezon City government projects."/>
        <meta name="author" content="Confractus" />
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Project List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
    </head>
    <body>
        <div class="app-container">
            <?php include('../../components/header.php'); ?>

            <div class="content-area">
                <?php include('../../components/sideNavigation.php'); ?>

                <main class="main-view">
                    <div class="container-fluid">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/QTrace-Website/dashboard">Home</a></li>
                                <li class="breadcrumb-item active">Project List</li>
                            </ol>
                        </nav>

                        <div class="row mb-4">
                            <div class="col">
                                <h2 class="fw-bold">Project List</h2>
                                <p>Manage and view all projects in the system</p>
                            </div>
                            <div class="col-auto">
                                <a href="/QTrace-Website/pages/admin/add_project.php" class="btn bg-color-primary text-light fw-medium">
                                    <i class="bi bi-plus-lg me-1"></i> Add New Project
                                </a>
                            </div>
                        </div>

                        <!-- Filters Section -->
                        <div class="row g-3 mb-4">
                            <div class="col-12 card border-0 shadow-sm p-3">
                                <h5 class="fw-bold mb-3">Filters</h5>
                                <form method="GET" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="searchInput" class="form-label">Search</label>
                                        <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search by title or description..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="statusFilter" class="form-label">Status</label>
                                        <select class="form-select" id="statusFilter" name="status">
                                            <option value="">All Status</option>
                                            <option value="active" <?php echo ($_GET['status'] ?? '') === 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="completed" <?php echo ($_GET['status'] ?? '') === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                            <option value="planned" <?php echo ($_GET['status'] ?? '') === 'planned' ? 'selected' : ''; ?>>Planned</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="contractorFilter" class="form-label">Contractor</label>
                                        <select class="form-select" id="contractorFilter" name="contractor_id">
                                            <option value="">All Contractors</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end gap-2">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                        <a href="?page=1" class="btn btn-outline-secondary">Clear</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Projects Table -->
                        <div class="row g-3">
                            <div class="col-12 card border-0 shadow-sm p-3">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Project Title</th>
                                                <th>Status</th>
                                                <th>Budget</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="projectsTableBody">
                                            <?php if (empty($projects)): ?>
                                                <tr><td colspan="6" class="text-center text-muted py-5">No projects found</td></tr>
                                            <?php else: ?>
                                                <?php foreach ($projects as $project): ?>
                                                    <tr>
                                                        <td class="fw-medium"><?php echo htmlspecialchars($project['Project_Title']); ?></td>
                                                        <td><span class="badge bg-info"><?php echo htmlspecialchars($project['Project_Status']); ?></span></td>
                                                        <td>₱<?php echo number_format($project['Project_Budget'], 2); ?></td>
                                                        <td><?php echo !empty($project['Project_StartedDate']) ? date('M d, Y', strtotime($project['Project_StartedDate'])) : '-'; ?></td>
                                                        <td><?php echo !empty($project['Project_EndDate']) ? date('M d, Y', strtotime($project['Project_EndDate'])) : '-'; ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></a>
                                                            <a href="/QTrace-Website/pages/admin/edit_project.php?id=<?php echo $project['Project_Id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                                                            <button class="btn btn-sm btn-outline-danger delete-btn" data-id="<?php echo $project['Project_Id']; ?>" title="Delete"><i class="bi bi-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <?php if (!empty($pagination) && $pagination['total_pages'] > 0): ?>
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>
                                        <small class="text-muted">
                                            Showing 
                                            <span id="recordStart"><?php echo (($pagination['current_page'] - 1) * $pagination['per_page']) + 1; ?></span> 
                                            to 
                                            <span id="recordEnd"><?php echo min($pagination['current_page'] * $pagination['per_page'], $pagination['total_records']); ?></span> 
                                            of 
                                            <span id="totalRecords"><?php echo $pagination['total_records']; ?></span> 
                                            projects
                                        </small>
                                    </div>
                                    <nav>
                                        <ul class="pagination mb-0">
                                            <li class="page-item <?php echo $pagination['current_page'] === 1 ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo max(1, $pagination['current_page'] - 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&contractor_id=<?php echo urlencode($_GET['contractor_id'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Previous</a>
                                            </li>
                                            <li class="page-item"><span class="page-link"><?php echo $pagination['current_page']; ?> of <?php echo $pagination['total_pages']; ?></span></li>
                                            <li class="page-item <?php echo $pagination['current_page'] === $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo min($pagination['total_pages'], $pagination['current_page'] + 1); ?>&status=<?php echo urlencode($_GET['status'] ?? ''); ?>&contractor_id=<?php echo urlencode($_GET['contractor_id'] ?? ''); ?>&search=<?php echo urlencode($_GET['search'] ?? ''); ?>">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Delete project handler
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const projectId = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this project?')) {
                        // TODO: Implement delete functionality
                        console.log('Delete project ID:', projectId);
                    }
                });
            });
        </script>
    </body>
</html>