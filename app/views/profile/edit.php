<?php require APP_PATH . '/views/layouts/header.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Success!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your profile has been successfully updated.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
<?php endif; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="mb-0">Edit Profile</h3>
                </div>
                <div class="card-body p-4">
                    <form action="<?= URL_ROOT ?>/profile/edit" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="<?= htmlspecialchars($_SESSION['name'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" name="age" 
                                    value="<?= htmlspecialchars($_SESSION['age'] ?? '') ?>" min="1" max="150">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" 
                                    value="<?= htmlspecialchars($_SESSION['phone'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="password-section mt-4 pt-3 border-top">
                            <h5 class="mb-3">Change Password</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" 
                                        name="current_password">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" 
                                        name="new_password">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="<?= URL_ROOT ?>/dashboard" class="btn btn-light">Cancel</a>
                            <button type="submit" class="btn btn-dark">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this CSS to your stylesheet or in a style tag -->
<style>
    .card {
        border-radius: 15px;
        border: none;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
        background: #000;
        color: #fff;
    }
    
    .card-header h3 {
        color: #fff;
        font-weight: 600;
        margin: 0;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 10px 15px;
    }
    
    .form-control:focus {
        border-color: #000;
        box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
    }

    /* Modal styles */
    .modal-content {
        border-radius: 12px;
        border: none;
    }

    .modal-header {
        background: #000;
        color: #fff;
        border-radius: 12px 12px 0 0;
    }

    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .modal-footer {
        border-top: 1px solid #e0e0e0;
    }

    /* Links */
    a {
        color: #000;
        text-decoration: none;
    }

    a:hover {
        color: #333;
    }

    .btn-dark {
        background: #000;
        border: none;
        color: #fff;
    }
    
    .btn-dark:hover {
        background: #333;
    }
    
    .btn-light {
        background: #fff;
        border: 1px solid #e0e0e0;
    }
</style>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 