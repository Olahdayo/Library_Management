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
        max-width: 400px;
        padding: 2rem;
    }
    
    .auth-header {
        text-align: center;
        padding-bottom: 2rem;
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
    
    .auth-icon {
        width: 70px;
        height: 70px;
        background: #212529;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }
    
    .auth-icon i {
        font-size: 1.75rem;
        color: white;
    }
    
    .form-control {
        background: #ffffff;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
        height: auto;
        font-size: 0.95rem;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: #212529;
        box-shadow: 0 0 0 3px rgba(33, 37, 41, 0.1);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
    }
    
    .btn-login {
        background: #212529;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.2s ease;
        width: 100%;
        margin-top: 1rem;
    }
    
    .btn-login:hover {
        background: #1a1d20;
        transform: translateY(-1px);
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #dee2e6;
    }
    
    .auth-footer a {
        color: #215529;
        text-decoration: none;
        font-weight: 500;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="container d-flex align-items-center justify-content-center auth-wrapper">
    <div class="login-container auth-card">
        <h2 class="text-center mb-4 auth-header">Login</h2>
        
        <?php if (!empty($data['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($data['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo URL_ROOT; ?>/auth/login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-login">Login</button>
        </form>

        <div class="links auth-footer">
            <a href="<?php echo URL_ROOT; ?>/auth/signup">Don't have an account? Sign up</a>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>
 