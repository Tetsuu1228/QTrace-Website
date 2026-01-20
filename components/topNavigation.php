<style>
    .dropdown-menu-dark .dropdown-item.active, 
    .dropdown-menu-dark .dropdown-item:active {
        background-color: var(--background) !important; 
        color: var(--primary) !important;            
    }

    .dropdown-menu-dark .dropdown-item.active i {
        color: var(--primary) !important;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-color-primary sticky-top shadow-sm py-3 fw-medium">
    <div class="container ">
        <a class="navbar-brand d-flex align-items-center" style="line-height: 0.8;" href="#">
            <img src="/QTrace-Website/assets/image/QTraceLogo.png" alt="QTrace Logo" srcset="" style="width: 31px;" class="me-2">
            <div>
                <span class="fs-5 lh-0">QTrace</span>
                <br>
                <span class=" fw-normal" style="font-size: 0.75rem;">Quezon City Transparency</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-lg-5">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>" href="/QTrace-Website/home">
                        <i class="pe-1 bi bi-house me-1"></i>Home
                    </a>
                </li>
                
                <!-- Projects Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?php echo in_array($current_page, ['projects', 'map', 'contractor', 'audit']) ? 'active' : ''; ?>" href="#" id="navbarDropdownProjects" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="pe-1 bi bi-briefcase me-1"></i>Projects
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark p-2 bg-color-primary " aria-labelledby="navbarDropdownProjects">
                        <li class="py-1">
                            <a class="dropdown-item <?php echo ($current_page == 'projects') ? 'active' : ''; ?>" href="/QTrace-Website/projects">
                                <i class="pe-1 bi bi-list-ul me-2"></i>View Projects
                            </a>
                        </li>
                        <li class="py-1">
                            <a class="dropdown-item <?php echo ($current_page == 'map') ? 'active' : ''; ?>" href="/QTrace-Website/map">
                                <i class="pe-1 bi bi-geo-alt me-2"></i>Maps
                            </a>
                        </li>
                        <li class="py-1">
                            <a class="dropdown-item <?php echo ($current_page == 'contractor') ? 'active' : ''; ?>" href="/QTrace-Website/contractors">
                                <i class="pe-1 bi bi-person-badge me-2"></i>Contractors
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider bg-light">
                        </li>
                        <li class="py-1">
                            <a class="dropdown-item <?php echo ($current_page == 'audit') ? 'active' : ''; ?>" href="/QTrace-Website/projects-audit">
                                <i class="pe-1 bi bi-clipboard-check me-2"></i>Projects Audit
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'articles') ? 'active' : ''; ?>" href="/QTrace-Website/articles">
                        <i class="pe-1 bi bi-newspaper me-1"></i>Articles
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'aboutUs') ? 'active' : ''; ?>" href="/QTrace-Website/about">
                        <i class="pe-1 bi bi-info-circle me-1"></i>About Us
                    </a>
                </li>
                
                <?php if (isset($_SESSION['user_ID'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-profile-section" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="pe-1 bi bi-person-circle fs-6"></i>
                            <span class="fw-medium d-none d-lg-inline">
                                <?php echo htmlspecialchars($_SESSION['FirstName']); ?>
                            </span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark p-2 bg-color-primary" aria-labelledby="navbarDropdownUser">
                            <li>
                                <a class="dropdown-item" href="/QTrace-Website/logout">
                                    <i class="pe-1 bi bi-box-arrow-right me-2"></i>Log Out
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link login-link" href="/QTrace-Website/login">
                            <i class="pe-1 bi bi-box-arrow-in-right me-1"></i>Log In
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>