<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Students</h5>
                    <h2><?= $totalStudents ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Books</h5>
                    <h2><?= $totalBooks ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Borrows</h5>
                    <h2><?= $activeBorrows ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Overdue Books</h5>
                    <h2><?= $overdueBorrows ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Current Borrows</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Username</th>
                            <th>Book Title</th>
                            <th>Borrow Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentBorrows)): ?>
                            <?php foreach ($recentBorrows as $index => $borrow): ?>
                                <tr>
                                    <td><?= (($current_page - 1) * 30) + $index + 1 ?></td>
                                    <td><?= htmlspecialchars($borrow['student_name']) ?></td>
                                    <td><?= htmlspecialchars($borrow['student_username']) ?></td>
                                    <td><?= htmlspecialchars($borrow['book_title']) ?></td>
                                    <td><?= date('M d, Y', strtotime($borrow['borrow_date'])) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $borrow['borrow_status'] === 'BORROWED' ? 'success' : 'danger' ?>">
                                            <?= $borrow['borrow_status'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No active borrows found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <ul class="pagination justify-content-center">
                        <?php if ($current_page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $current_page - 1 ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = max(1, $current_page - 2); $i <= min($pages, $current_page + 2); $i++): ?>
                            <li class="page-item <?= $i === $current_page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $pages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $current_page + 1 ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/admin-footer.php'; ?> 