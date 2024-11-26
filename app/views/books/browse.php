<?php require APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Available Books</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book['title']) ?></td>
                <td><?= htmlspecialchars($book['author']) ?></td>
                <td><?= htmlspecialchars(strlen($book['description']) > 50 ? 
                    substr($book['description'], 0, 50) . '...' : 
                    $book['description']) ?></td>
                <td>
                    <span class="badge <?= $book['available_copies'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                        <?= htmlspecialchars($book['available']) ?>
                    </span>
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#bookModal<?= $book['id'] ?>">
                        Details
                    </button>
                    <a href="/books/borrow/<?= $book['id'] ?>" 
                       class="btn btn-primary btn-sm <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>"
                       <?= $book['available_copies'] <= 0 ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                        Borrow
                    </a>
                </td>
            </tr>

            <!-- Modal for each book -->
            <div class="modal fade" id="bookModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="bookModalLabel<?= $book['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel<?= $book['id'] ?>"><?= htmlspecialchars($book['title']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="<?= htmlspecialchars($book['cover_image'] ?? '/assets/images/no-cover.jpg') ?>" 
                                         class="img-fluid" alt="Book cover">
                                </div>
                                <div class="col-md-8">
                                    <h6>Author</h6>
                                    <p><?= htmlspecialchars($book['author']) ?></p>
                                    
                                    <h6>Description</h6>
                                    <p><?= htmlspecialchars($book['description']) ?></p>
                                    
                                    <h6>ISBN</h6>
                                    <p><?= htmlspecialchars($book['isbn'] ?? 'N/A') ?></p>
                                    
                                    <h6>Publication Year</h6>
                                    <p><?= htmlspecialchars($book['publication_year'] ?? 'N/A') ?></p>
                                    
                                    <h6>Available Copies</h6>
                                    <p><?= htmlspecialchars($book['available_copies']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="/books/borrow/<?= $book['id'] ?>" 
                               class="btn btn-primary <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>"
                               <?= $book['available_copies'] <= 0 ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                                Borrow
                            </a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 