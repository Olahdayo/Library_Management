<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Books</h2>
        <a href="<?= URL_ROOT ?>/admin/addBook" class="btn btn-primary">
            <i class="bi bi-plus"></i> Add New Book
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Available Copies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $book): ?>
                            <tr>
                                <td><?= (($current_page - 1) * 30) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= htmlspecialchars($book['isbn']) ?></td>
                                <td><?= $book['available_copies'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editBookModal"
                                            data-id="<?= $book['id'] ?>"
                                            data-title="<?= htmlspecialchars($book['title']) ?>"
                                            data-author="<?= htmlspecialchars($book['author']) ?>"
                                            data-isbn="<?= htmlspecialchars($book['isbn']) ?>"
                                            data-copies="<?= $book['available_copies'] ?>">
                                        <i class="bi bi-pencil"></i> Edit
                                    </button>
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

<!-- Edit Book Modal -->
<div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="editBookForm" onsubmit="return confirm('Are you sure you want to update this book?');">
                <div class="modal-body">
                    <input type="hidden" id="bookId" name="id">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" required>
                    </div>
                    <div class="mb-3">
                        <label for="available_copies" class="form-label">Available Copies</label>
                        <input type="number" class="form-control" id="available_copies" name="available_copies" required min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editBookModal = document.getElementById('editBookModal');
    const editBookForm = document.getElementById('editBookForm');
    
    editBookModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const author = button.getAttribute('data-author');
        const isbn = button.getAttribute('data-isbn');
        const copies = button.getAttribute('data-copies');

        editBookForm.action = '<?= URL_ROOT ?>/admin/editBook/' + id;
        editBookForm.querySelector('#bookId').value = id;
        editBookForm.querySelector('#title').value = title;
        editBookForm.querySelector('#author').value = author;
        editBookForm.querySelector('#isbn').value = isbn;
        editBookForm.querySelector('#available_copies').value = copies;
    });
});
</script>

<?php require APP_PATH . '/views/layouts/admin-footer.php'; ?>