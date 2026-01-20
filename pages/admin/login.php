<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- SEO -->
        <meta name="description" content="Login page for the QTRACE system."/>
        <meta name="author" content="Confractus" />
        <link rel="icon" type="image/png" sizes="16x16" href="" />
        <title>QTrace - Login</title>
        <!-- Bootstrap CSS Link-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Basta need toh-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" />
        <!-- General Css Link -->
        <link rel="stylesheet" href="/QTrace-Website/assets/css/styles.css" />
        <!-- Custome Css For This Page Only  -->
        <style>
        /* Image Preview Box */
        .text-color {
            color: var(--primary) !important;
        }
        </style>
    </head>
    <body class="bg-light d-flex align-items-center min-vh-100">

        <div class="container">
            <div class="row g-0 shadow rounded-4 overflow-hidden bg-white mx-auto" style="max-width: 1000px;">
                
                <div class="col-lg-5 bg-color-primary text-white p-5 d-flex flex-column justify-content-center">
                    <img src="/QTrace-Website/assets/image/QTraceLogo.png" alt="QTrace Logo" srcset="" style="width: 60px;">
                    <h1 class="h2 fw-bold mb-3">Welcome to QTRACE</h1>
                    <p class="mb-5 opacity-75">Sign in to access your personalized dashboard and track projects.</p>
                    
                    <div class="d-flex mb-3">
                        <i class="bi bi-shield-check me-3 fs-4"></i>
                        <div><h6 class="mb-0 fw-bold">Secure Access</h6><small class="opacity-75">Government-grade security</small></div>
                    </div>
                </div>

                <div class="col-lg-7 p-5">
                    <h3 class="fw-bold mb-4 text-color">Login</h3>

                    <?php 
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger py-2 small">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']); // Clear it so it doesn't show again on refresh
                        }
                        ?>

                        <?php if (isset($_GET['status']) && $_GET['status'] == 'timeout'): ?>
                            <div class="alert alert-warning py-2 small">Session expired. Please log in again.</div>
                        <?php endif; ?>

                    <form method="POST" action="/QTrace-Website/database/controllers/login_action.php">
                        <div class="mb-3">
                            <label class="form-label small fw-medium">QC ID Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="number" name="QC_ID_Number" class="form-control bg-light border-start-0" placeholder="123456789" >
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" name="user_Password" class="form-control bg-light border-start-0" placeholder="••••••••" >
                            </div>
                        </div>

                        <button type="submit" class="btn bg-color-primary text-light w-100 py-2 fw-bold">Sign In</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Custome Script For This Page Only  --> 
        <script>

        </script>
            
        <!-- Reusable Script -->
        <script src="/QTrace-Website/assets/js/mouseMovement.js"></script>
        <script src="/QTrace-Website/assets/js/imageholder.js"></script>
        <script src="/QTrace-Website/assets/js/dynamicFieldText.js"></script>
        <script src="/QTrace-Website/assets/js/dynamicFieldFile.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
