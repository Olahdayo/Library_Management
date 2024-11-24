<?php require APP_PATH . '/views/layouts/header.php'; ?>

<?php
error_log('Current session data: ' . print_r($_SESSION, true));
?>

<style>
    /* Reset and base styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
    }

    /* Main content wrapper */
    .dashboard-wrapper {
        flex: 1 0 auto; /* This ensures the footer stays at bottom */
        width: 100%;
        padding: 2rem;
    }

    .dashboard-content {
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    /* Student Info Section */
    .student-info-card {
        background: #000;
        color: #fff;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .student-details h1 {
        font-size: 1.75rem;
        margin: 0;
        font-weight: 600;
    }

    .student-details p {
        margin: 0.5rem 0;
        opacity: 0.8;
    }

    .edit-profile-btn {
        padding: 0.75rem 1.5rem;
        background: transparent;
        border: 2px solid #fff;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .edit-profile-btn:hover {
        background: #fff;
        color: #000;
    }

    /* Borrowed Books Section */
    .borrowed-books {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #000;
    }

    /* Quick Actions Grid */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .action-card {
        background: #fff;
        padding: 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        color: #000;
        transition: all 0.3s ease;
        border: 1px solid #eee;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #000;
    }

    .action-card i {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .action-card h3 {
        font-size: 1.2rem;
        margin: 0;
        font-weight: 600;
    }

    .action-card p {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }

    /* Footer Styles */
    .footer {
        flex-shrink: 0; /* Prevents footer from shrinking */
        background-color: #000;
        color: #fff;
        padding: 3rem 0 1rem 0;
        width: 100%;
        margin-top: auto;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 0 2rem;
    }

    .footer-section h3 {
        font-size: 1.2rem;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .footer-section h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: #fff;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.8rem;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .footer-section ul li a:hover {
        opacity: 0.7;
    }

    .footer-section i {
        margin-right: 10px;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        color: #fff;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .social-links a:hover {
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-bottom p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 3rem;
        }

        .footer-section h3::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .social-links {
            justify-content: center;
        }
    }

    .welcome-section {
        padding: 2rem 0;
    }
    
    .welcome-section h1 {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }
</style>

<!-- Main Content Wrapper -->
<div class="dashboard-wrapper">
    <div class="dashboard-content">
        <!-- Student Info -->
        <div class="student-info-card">
            <div class="student-details">
                <h1>Welcome, <?php 
                    if (isset($_SESSION['name'])) {
                        $firstName = explode(' ', $_SESSION['name'])[0]; // Get first word before space
                        echo $firstName;
                    } else {
                        echo $_SESSION['username'];
                    }
                ?>!</h1>
                <div class="info-grid">
                    <p><i class="bi bi-person-badge"></i> Student ID: <?php echo $_SESSION['user_id'] ?? 'Not available'; ?></p>
                    <p><i class="bi bi-envelope"></i> Email: <?php echo $_SESSION['email'] ?? 'Not available'; ?></p>
                    <p><i class="bi bi-telephone"></i> Phone: <?php echo $_SESSION['phone'] ?? 'Not available'; ?></p>
                    <p><i class="bi bi-book"></i> Books Borrowed: <?php echo $_SESSION['total_books_borrowed'] ?? '0'; ?></p>
                </div>
            </div>
            <a href="<?php echo URL_ROOT; ?>/profile/edit" class="edit-profile-btn">Edit Profile</a>
        </div>

        <!-- Currently Borrowed Books -->
        <div class="borrowed-books">
            <h2 class="section-title">Currently Borrowed Books</h2>
            <?php if (empty($_SESSION['total_books_borrowed'])): ?>
                <p>You haven't borrowed any books yet.</p>
            <?php else: ?>
                <!-- Add borrowed books list here -->
            <?php endif; ?>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="<?php echo URL_ROOT; ?>/books" class="action-card">
                <i class="bi bi-book"></i>
                <h3>Browse Books</h3>
                <p>Search and borrow from our collection</p>
            </a>
            <a href="<?php echo URL_ROOT; ?>/profile/edit" class="action-card">
                <i class="bi bi-person-gear"></i>
                <h3>Update Profile</h3>
                <p>Manage your account information</p>
            </a>
            <a href="<?php echo URL_ROOT; ?>/books/history" class="action-card">
                <i class="bi bi-clock-history"></i>
                <h3>Borrowing History</h3>
                <p>View your past transactions</p>
            </a>
        </div>
    </div>
</div>

<?php 
// Debug line to check if the footer file exists
$footerPath = APP_PATH . '/views/layouts/footer.php';
if (file_exists($footerPath)) {
    echo "<!-- Footer file exists -->";
    require $footerPath;
} else {
    echo "<!-- Footer file not found at: " . $footerPath . " -->";
}
?>