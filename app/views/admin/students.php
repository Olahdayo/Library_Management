<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
    <h2 class="mb-4">Registered Students</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Age</th>
                            <th class="bg-success text-white">Books Borrowed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $student): ?>
                            <tr>
                                <td><?= (($current_page - 1) * 30) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($student['name']) ?></td>
                                <td><?= htmlspecialchars($student['UserName']) ?></td>
                                <td><?= htmlspecialchars($student['email']) ?></td>
                                <td><?= htmlspecialchars($student['phone']) ?></td>
                                <td><?= $student['age'] ?></td>
                                <td class="bg-success text-white"><?= ($student['books_borrowed'] > 0) ? $student['books_borrowed'] : 'None' ?></td>
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

<?php require APP_PATH . '/views/layouts/admin-footer.php'; ?> 