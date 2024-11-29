<?php require APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $_SESSION['warning'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

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
                                    data-book-description="<?= htmlspecialchars($book['description']) ?>"
                                    data-book-year="<?= htmlspecialchars($book['publication_year'] ?? 'N/A') ?>"
                                    <?= $book['available_copies'] <= 0 ? 'disabled' : '' ?>>
                                    Borrow
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Update the Borrow Modal -->
<div class="modal fade" id="borrowModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Borrow Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="book-details mb-3">
                    <p><strong>Title:</strong> <span id="modalBookTitle"></span></p>
                    <p><strong>Author:</strong> <span id="modalBookAuthor"></span></p>
                    <p><strong>ISBN:</strong> <span id="modalBookISBN"></span></p>
                    <p><strong>Description:</strong> <span id="modalBookDescription"></span></p>
                    <p><strong>Publication Year:</strong> <span id="modalBookYear"></span></p>
                </div>
                <form id="borrowForm" action="<?= URL_ROOT ?>/books/borrow" method="POST">
                    <input type="hidden" name="book_id" id="modalBookId">
                    <div class="mb-3">
                        <label for="return_date" class="form-label">Return Date</label>
                        <input type="date" class="form-control" name="return_date" id="return_date" required
                            min="<?= date('Y-m-d') ?>"
                            max="<?= date('Y-m-d', strtotime('+30 days')) ?>">
                        <div class="form-text">Return date must be within 30 days from today.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="showConfirmation">Confirm Borrow</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Borrow</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to borrow this book?</p>
                <p><strong>Title:</strong> <span id="confirmBookTitle"></span></p>
                <p><strong>Return Date:</strong> <span id="confirmReturnDate"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmBorrow">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Success</h5>
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

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Warning</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="warningMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const borrowModal = document.getElementById('borrowModal');
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        const borrowForm = document.getElementById('borrowForm');
        
        // Handle borrow modal data
        borrowModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            
            document.getElementById('modalBookId').value = button.getAttribute('data-book-id');
            document.getElementById('modalBookTitle').textContent = button.getAttribute('data-book-title');
            document.getElementById('modalBookAuthor').textContent = button.getAttribute('data-book-author');
            document.getElementById('modalBookISBN').textContent = button.getAttribute('data-book-isbn');
            document.getElementById('modalBookDescription').textContent = button.getAttribute('data-book-description');
            document.getElementById('modalBookYear').textContent = button.getAttribute('data-book-year');
        });

        // Show confirmation modal when clicking Confirm Borrow
        document.getElementById('showConfirmation').addEventListener('click', function() {
            const returnDate = document.getElementById('return_date');
            if (!returnDate.value) {
                alert('Please select a return date');
                return;
            }

            document.getElementById('confirmBookTitle').textContent = 
                document.getElementById('modalBookTitle').textContent;
            document.getElementById('confirmReturnDate').textContent = 
                new Date(returnDate.value).toLocaleDateString();

            bootstrap.Modal.getInstance(borrowModal).hide();
            confirmationModal.show();
        });

        // Handle final confirmation
        document.getElementById('confirmBorrow').addEventListener('click', function() {
            borrowForm.submit();
        });

        // Success and warning modal handling
        <?php if (isset($_SESSION['success'])): ?>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            var warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
            document.getElementById('warningMessage').textContent = '<?= addslashes($_SESSION['error']) ?>';
            warningModal.show();
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    });
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>