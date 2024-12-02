<?php require APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Borrowing History</h2>
    
    <?php if (empty($borrowHistory)): ?>
        <div class="alert alert-info">No borrowing history yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowHistory as $transaction): ?>
                        <tr>
                            <td><?= htmlspecialchars($transaction['title']) ?></td>
                            <td><?= htmlspecialchars($transaction['author']) ?></td>
                            <td><?= date('M d, Y', strtotime($transaction['borrow_date'])) ?></td>
                            <td><?= date('M d, Y', strtotime($transaction['return_date'])) ?></td>
                            <td>
                                <?php 
                                // Determine the status
                                if ($transaction['status'] === 'returned') {
                                    $status = 'Returned';
                                } elseif (strtotime($transaction['return_date']) < time()) {
                                    $status = 'Overdue'; 
                                } else {
                                    $status = 'Active'; 
                                }
                                ?>
                                <span class="badge bg-<?= $status === 'Overdue' ? 'danger' : 'success' ?>">
                                    <?= $status ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <div class="mt-3">
        <a href="<?= URL_ROOT ?>/dashboard" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 