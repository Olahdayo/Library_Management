<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
    <h2 class="mb-4">Borrow History</h2>

    <div class="card">
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
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $borrow): ?>
                            <tr>
                                <td><?= (($current_page - 1) * 30) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($borrow['student_name']) ?></td>
                                <td><?= htmlspecialchars($borrow['student_username']) ?></td>
                                <td><?= htmlspecialchars($borrow['book_title']) ?></td>
                                <td><?= date('M d, Y', strtotime($borrow['borrow_date'])) ?></td>
                                <td>
                                    <?= $borrow['return_date'] 
                                        ? date('M d, Y', strtotime($borrow['return_date'])) 
                                        : '-' 
                                    ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $borrow['borrow_status'] === 'BORROWED' ? 'success' : 
                                        ($borrow['borrow_status'] === 'OVERDUE' ? 'danger' : 'warning') 
                                    ?>">
                                        <?= $borrow['borrow_status'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
 