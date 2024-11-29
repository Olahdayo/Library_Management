<?php require APP_PATH . '/views/layouts/header.php'; ?>

<?php
error_log('Current session data: ' . print_r($_SESSION, true));
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        width: 100%;
        display: flex;
        flex-direction: column;
        background-color: #f8f9fa;
        overflow-x: hidden;
    }

    .dashboard-wrapper {
        flex: 1 0 auto;
        width: 100%;
        padding: 2rem;
        margin: 0;
    }

    .dashboard-content {
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    /* Content container styles */
    .section {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .table-responsive {
        width: 100%;
        margin: 0;
        padding: 0;
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 1rem;
        }
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
        align-items: flex-start;
        gap: 1rem;
    }

    .student-details {
        flex: 1;
    }

    .student-details h1 {
        font-size: 1.75rem;
        margin: 0;
        font-weight: 600;
    }

    .info-grid {
        margin-top: 1rem;
    }

    .info-grid p {
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
        white-space: nowrap;
    }

    .edit-profile-btn:hover {
        background: #fff;
        color: #000;
    }

    @media (max-width: 768px) {
        .student-info-card {
            flex-direction: column;
            padding: 1.5rem;
            align-items: stretch;
            margin-top: 15px;
        }

        .student-details h1 {
            font-size: 1.5rem;
        }

        .edit-profile-btn {
            display: block;
            text-align: center;
            margin-top: 1rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
    }

    /* Borrowed Books Section */
    .borrowed-books {
        background: #fff;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

    .welcome-section {
        padding: 2rem 0;
    }

    .welcome-section h1 {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .blink-warning {
        animation: blink 1s infinite;
        color: #ff4444;
        font-weight: bold;
    }

    @keyframes blink {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
</style>

<body>
    <!-- Main Content Wrapper -->
    <div class="dashboard-wrapper mt-5">
        <div class="dashboard-content">
            <!-- Student Info -->
            <div class="section">
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
                            <?php
                            $hasOverdue = false;
                            foreach ($currentBorrows as $book) {
                                if (strtotime($book['return_date']) < strtotime('today')) {
                                    $hasOverdue = true;
                                    break;
                                }
                            }
                            if ($hasOverdue): ?>
                                <p class="blink-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    You have overdue book(s),Please return!!!
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="<?php echo URL_ROOT; ?>/profile/edit" class="edit-profile-btn">Edit Profile</a>
                </div>
            </div>

            <!-- Currently Borrowed Books Section -->
            <div class="section">
                <h3>Currently Borrowed Books</h3>
                <?php if (empty($currentBorrows)): ?>
                    <p>No books currently borrowed.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($currentBorrows as $book): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($book['title']) ?></td>
                                        <td><?= htmlspecialchars($book['author']) ?></td>
                                        <td><?= date('M d, Y', strtotime($book['return_date'])) ?></td>
                                        <td>
                                            <?php if (strtotime($book['return_date']) < strtotime('today')): ?>
                                                <span class="badge bg-danger">Overdue</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#returnModal<?= $book['id'] ?>">
                                                Return
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Actions -->
            <div class="section">
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
                    <a href="<?php echo URL_ROOT; ?>/transactions/history" class="action-card">
                        <i class="bi bi-clock-history"></i>
                        <h3>Borrowing History</h3>
                        <p>View your past transactions</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Confirmation Modals -->
    <?php foreach ($currentBorrows as $book): ?>
        <div class="modal fade" id="returnModal<?= $book['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Return</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to return this book?</p>
                        <p><strong>Title:</strong> <?= htmlspecialchars($book['title']) ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="<?= URL_ROOT ?>/transactions/returnBook" method="POST" class="d-inline">
                            <input type="hidden" name="transaction_id" value="<?= $book['id'] ?>">
                            <button type="submit" class="btn btn-primary">Confirm Return</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Book returned successfully!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <?php require APP_PATH . '/views/layouts/footer.php'; ?>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show success modal if success message exists
        <?php if (isset($_SESSION['success'])): ?>
            new bootstrap.Modal(document.getElementById('successModal')).show();
        <?php
            unset($_SESSION['success']);
        endif;
        ?>
    });
</script>