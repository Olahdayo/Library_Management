<?php require APP_PATH . '/views/layouts/header.php'; ?>

<style>
    .auth-wrapper {
        min-height: 100vh;
        background: #f8f9fa;
    }
    
    .auth-card {
        background: #ffffff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        max-width: 800px;
        width: 100%;
    }
    
    .auth-header {
        text-align: center;
        padding: 2rem 0;
    }
    
    .auth-header h1 {
        font-size: 1.75rem;
        color: #212529;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .auth-header p {
        color: #6c757d;
        font-size: 0.95rem;
    }
    
    .form-control, .form-select {
        background: #ffffff;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        height: auto;
        font-size: 0.95rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #212529;
        box-shadow: 0 0 0 3px rgba(33, 37, 41, 0.1);
    }
    
    .btn-signup {
        background: #212529;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        color: #ffffff;
    }
    
    .btn-signup:hover {
        background: #000000;
        transform: translateY(-1px);
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        color: #6c757d;
    }
    
    .auth-footer a {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-label {
        font-weight: 500;
        color: #212529;
    }
</style>

<div class="auth-wrapper d-flex align-items-center justify-content-center p-4">
    <div class="auth-card p-4">
        <div class="auth-header">
            <h1>Create Account</h1>
            <p>Fill in your details to get started</p>
        </div>

        <?php if (!empty($data['errors']['general'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($data['errors']['general']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo URL_ROOT; ?>/auth/signup">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control <?php echo (!empty($data['errors']['name'])) ? 'is-invalid' : ''; ?>" 
                               name="name" value="<?php echo htmlspecialchars($data['name']); ?>">
                        <?php if (!empty($data['errors']['name'])): ?>
                            <div class="error-message"><?php echo $data['errors']['name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control <?php echo (!empty($data['errors']['username'])) ? 'is-invalid' : ''; ?>" 
                               name="username" value="<?php echo htmlspecialchars($data['username']); ?>">
                        <?php if (!empty($data['errors']['username'])): ?>
                            <div class="error-message"><?php echo $data['errors']['username']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control <?php echo (!empty($data['errors']['email'])) ? 'is-invalid' : ''; ?>" 
                               name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
                        <?php if (!empty($data['errors']['email'])): ?>
                            <div class="error-message"><?php echo $data['errors']['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control <?php echo (!empty($data['errors']['phone'])) ? 'is-invalid' : ''; ?>" 
                               name="phone" value="<?php echo htmlspecialchars($data['phone']); ?>">
                        <?php if (!empty($data['errors']['phone'])): ?>
                            <div class="error-message"><?php echo $data['errors']['phone']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" class="form-control <?php echo (!empty($data['errors']['age'])) ? 'is-invalid' : ''; ?>" 
                               name="age" value="<?php echo htmlspecialchars($data['age']); ?>">
                        <?php if (!empty($data['errors']['age'])): ?>
                            <div class="error-message"><?php echo $data['errors']['age']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select <?php echo (!empty($data['errors']['gender'])) ? 'is-invalid' : ''; ?>" 
                                name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" <?php echo $data['gender'] === 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo $data['gender'] === 'female' ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo $data['gender'] === 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <?php if (!empty($data['errors']['gender'])): ?>
                            <div class="error-message"><?php echo $data['errors']['gender']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control <?php echo (!empty($data['errors']['password'])) ? 'is-invalid' : ''; ?>" 
                               name="password">
                        <?php if (!empty($data['errors']['password'])): ?>
                            <div class="error-message"><?php echo $data['errors']['password']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?php echo (!empty($data['errors']['confirm_password'])) ? 'is-invalid' : ''; ?>" 
                               name="confirm_password">
                        <?php if (!empty($data['errors']['confirm_password'])): ?>
                            <div class="error-message"><?php echo $data['errors']['confirm_password']; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-signup w-100 mt-3">Create Account</button>
        </form>

        <div class="auth-footer">
            <a href="<?php echo URL_ROOT; ?>/auth/login">Already have an account? Login</a>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 