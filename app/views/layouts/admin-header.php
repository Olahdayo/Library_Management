<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: #333;
            color: white;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .admin-content {
            padding: 20px;
            margin-top: 70px;
        }

        .sidebar-link {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: 0.3s;
        }

        .sidebar-link:hover {
            background: #444;
            color: #fff;
        }

        .sidebar-link.active {
            background: #444;
        }

        .admin-header {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .sidebar-toggle {
            position: fixed;
            top: 0;
            right: 0;
            z-index: 1001;
            width: 40px;
            height: 40px;
            display: none;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 200px;
                display: none;
            }

            .sidebar-toggle {
                display: block;
            }

            .dropdown {
                margin-top: 35px;
            }
        }
        .content-spacing {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Toggle Button -->
            <button class="btn btn-secondary sidebar-toggle" id="toggleSidebar">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar -->
            <div class="col-md-2 admin-sidebar p-0" id="sidebar">
                <div class="d-flex flex-column">
                    <div class="p-3">
                        <h4><?= $_SESSION['name'] ?>'s Dashboard</h4>
                    </div>
                    <a href="<?= URL_ROOT ?>/admin/dashboard" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="<?= URL_ROOT ?>/admin/books" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'books') !== false ? 'active' : '' ?>">
                        <i class="bi bi-book me-2"></i> Manage Books
                    </a>
                    <a href="<?= URL_ROOT ?>/admin/students" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'students') !== false ? 'active' : '' ?>">
                        <i class="bi bi-people me-2"></i> Students
                    </a>
                    <a href="<?= URL_ROOT ?>/admin/borrowHistory" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'], 'borrowHistory') !== false ? 'active' : '' ?>">
                        <i class="bi bi-clock-history me-2"></i> Borrow History
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i><?= $_SESSION['name'] ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?= URL_ROOT ?>/auth/logout">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>


                <script>
                    // Show the toggle button on small screens
                    function updateToggleButtonVisibility() {
                        const toggleButton = document.getElementById('toggleSidebar');
                        const sidebar = document.getElementById('sidebar');
                        if (window.innerWidth < 768) {
                            toggleButton.style.display = 'block';
                        } else {
                            toggleButton.style.display = 'none';
                            sidebar.style.display = 'block'; 
                        }
                    }

                    // Toggle sidebar visibility
                    document.getElementById('toggleSidebar').addEventListener('click', function() {
                        const sidebar = document.getElementById('sidebar');
                        sidebar.style.display = sidebar.style.display === 'block' ? 'none' : 'block'; 
                    });

                    // Update toggle button visibility on load 
                    window.addEventListener('load', updateToggleButtonVisibility);
                    window.addEventListener('resize', updateToggleButtonVisibility);
                </script>
</body>

</html>