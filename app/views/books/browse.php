    <?php require APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Available Books</h2>
    <div class="table-container">
        <div class="table-scroll">
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
                            <button type="button" class="btn btn-primary btn-sm borrow-btn <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#borrowModal" 
                                    data-book-id="<?= $book['id'] ?>"
                                    data-book-title="<?= htmlspecialchars($book['title']) ?>"
                                    data-book-author="<?= htmlspecialchars($book['author']) ?>"
                                    data-book-isbn="<?= htmlspecialchars($book['isbn'] ?? 'N/A') ?>"
                                    <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>>
                                Borrow
                            </button>
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
                                    <form action="<?= URL_ROOT ?>/books/borrow" method="POST">
                                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                        <div class="mb-3">
                                            <label for="return_date" class="form-label">Return Date:</label>
                                            <input type="date" class="form-control" name="return_date" required
                                                   min="<?= date('Y-m-d') ?>" 
                                                   max="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>"
                                                <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>>
                                            Borrow
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Single Borrow Modal (outside the table) -->
<div class="modal fade" id="borrowModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borrow Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="book-details mb-3">
                    <h6>Book Details:</h6>
                    <p><strong>Title:</strong> <span id="modalBookTitle"></span></p>
                    <p><strong>Author:</strong> <span id="modalBookAuthor"></span></p>
                    <p><strong>ISBN:</strong> <span id="modalBookISBN"></span></p>
                </div>
                <form action="<?= URL_ROOT ?>/books/borrow" method="POST">
                    <input type="hidden" name="book_id" id="modalBookId">
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Return Date</label>
                        <input type="date" class="form-control" name="return_date" required
                               min="<?= date('Y-m-d') ?>" 
                               max="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                        <div class="form-text">Return date must be within 30 days from today.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm Borrow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Borrow</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to borrow this book?</p>
                <div class="book-details">
                    <p><strong>Title:</strong> <span id="confirmBookTitle"></span></p>
                    <p><strong>Return Date:</strong> <span id="confirmReturnDate"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmBorrowBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Book borrowed successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Js for date and borrow button -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const borrowModal = document.getElementById('borrowModal');
    const borrowForm = borrowModal.querySelector('form');
    let currentBookTitle = '';

    // Handle borrow button click
    borrowModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const bookId = button.getAttribute('data-book-id');
        const bookTitle = button.getAttribute('data-book-title');
        const bookAuthor = button.getAttribute('data-book-author');
        const bookISBN = button.getAttribute('data-book-isbn');

        currentBookTitle = bookTitle;

        // Update modal content
        document.getElementById('modalBookId').value = bookId;
        document.getElementById('modalBookTitle').textContent = bookTitle;
        document.getElementById('modalBookAuthor').textContent = bookAuthor;
        document.getElementById('modalBookISBN').textContent = bookISBN;
    });

    // Handle form submission
    borrowForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const returnDate = this.querySelector('input[name="return_date"]').value;
        if (!returnDate) {
            alert('Please select a return date');
            return;
        }

        // Update confirmation modal
        document.getElementById('confirmBookTitle').textContent = currentBookTitle;
        document.getElementById('confirmReturnDate').textContent = returnDate;

        // Hide borrow modal and show confirmation modal
        bootstrap.Modal.getInstance(borrowModal).hide();
        new bootstrap.Modal(document.getElementById('confirmationModal')).show();
    });

    // Handle confirmation
    document.getElementById('confirmBorrowBtn').addEventListener('click', function() {
        borrowForm.submit(); // Submit the form
    });

    // Show success modal if success message exists
    <?php if (isset($_SESSION['success'])): ?>
    new bootstrap.Modal(document.getElementById('successModal')).show();
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
});
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 