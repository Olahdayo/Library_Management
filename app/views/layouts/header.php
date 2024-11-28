<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] . ' - ' : ''; ?>Library Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        :root {
            --header-height: 70px;
        }

        .custom-navbar {
            background: #000;
            height: var(--header-height);
            padding: 0 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        body {
            padding-top: var(--header-height);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .brand-logo:hover {
            color: #f9f9f9;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
        }
        .nav-link:hover {
            color:#f9f9f9;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-auth {
            padding: 0.7rem 3rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-login:hover {
            background: #000;
            color: #fff;
        }

        .btn-signup {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
            padding-right:40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-signup:hover {
            background: #000;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #fff;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
        }

        .mobile-menu {
            display: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .custom-navbar {
                padding: 0 1rem;
            }

            .mobile-menu {
                display: block;
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
            }

            .nav-links,
            .auth-buttons {
                display: none;
            }

            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: var(--header-height);
                left: 0;
                right: 0;
                background: #000;
                padding: 1rem;
                gap: 1rem;
            }

            .user-profile .dropdown-toggle {
                font-size: 0;
            }

            .user-profile .dropdown-toggle i.bi-person,
            .user-profile .dropdown-toggle i.bi-caret-down-fill {
                font-size: 1rem;
                margin: 0 0.2rem;
            }

            .user-profile .dropdown-toggle span {
                display: none;
            }

            .dropdown-menu {
                position: fixed;
                top: var(--header-height);
                right: 0;
                left: auto;
                width: 200px;
            }

            .table-container {
                margin: 0 -1rem;
                padding: 0 1rem;
                overflow-x: auto;
            }

            .table-scroll {
                max-height: calc(100vh - var(--header-height) - 100px);
                overflow-y: auto;
            }

            .student-info-section {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .student-info-card {
                width: 100%;
            }

            .auth-form-container {
                padding: 1rem;
                margin: 1rem;
            }

            .form-control, .btn {
                width: 100%;
            }
        }

        .dropdown-menu {
            background-color: #fff;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            min-width: 200px;
            padding: 0.5rem 0;
        }

        .dropdown-item {
            color: #333;
            padding: 0.7rem 1.2rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #333;
            color: #fff;
        }

        .dropdown-item:hover i {
            color: #fff;
        }

        .dropdown-item i {
            font-size: 1.1rem;
            color: #666;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #eee;
        }

        .user-profile .dropdown-toggle {
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            padding: 0.5rem 0;
            background: transparent;
            border: none;
        }

        .user-profile .dropdown-toggle::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transition: width 0.3s ease;
        }

        .user-profile .dropdown-toggle:hover::after,
        .user-profile .show .dropdown-toggle::after {
            width: 100%;
        }

        .user-profile .dropdown-toggle::after {
            display: none;
        }

        .user-profile .dropdown-toggle i.bi-caret-down-fill {
            margin-left: 0.5rem;
            font-size: 0.8rem;
            transition: transform 0.2s ease;
        }

        .user-profile .show .dropdown-toggle i.bi-caret-down-fill {
            transform: rotate(180deg);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="custom-navbar">
        <div class="navbar-container">
            <a href="<?php echo URL_ROOT; ?>" class="brand-logo">
                <i class="bi bi-book"></i>
                LMS
            </a>

            <div class="mobile-menu">
                <i class="bi bi-list"></i>
            </div>

            <div class="nav-links">
                <?php 
                // Get the current URL path
                $currentPage = $_SERVER['REQUEST_URI'];
                
                // Check if we're on login or signup page
                if (strpos($currentPage, '/auth/login') !== false || strpos($currentPage, '/auth/signup') !== false): 
                ?>
                    <a href="<?php echo URL_ROOT; ?>/auth/login" class="nav-link">Home</a>
                <?php else: ?>
                    <a href="<?php echo URL_ROOT; ?>/books" class="nav-link">Browse Books</a>
                <?php endif; ?>
                
                <a href="<?php echo URL_ROOT; ?>/about" class="nav-link">About</a>
                <a href="<?php echo URL_ROOT; ?>/contact" class="nav-link">Contact</a>
            </div>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-profile">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle text-white" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                            <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : $_SESSION['username']; ?>
                            <i class="bi bi-caret-down-fill"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuButton">
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/dashboard/index">
                                    <i class="bi bi-person-circle"></i>
                                    <span>Profile</span>
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/auth/logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="<?php echo URL_ROOT; ?>/auth/login" class="btn btn-auth btn-login">Login</a>
                    <a href="<?php echo URL_ROOT; ?>/auth/signup" class="btn btn-auth btn-signup">Signup</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <script>
        document.querySelector('.mobile-menu').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
            document.querySelector('.auth-buttons')?.classList.toggle('active');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function(dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
</body>

</html>