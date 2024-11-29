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
        position: relative;
    }
    
    .btn-login:hover {
        background: #1a1d20;
        transform: translateY(-1px);
    }
    
    .btn-login.loading {
        color: transparent;
    }
    
    .btn-login.loading::after {
        content: '';
        position: absolute;
        width: 1.2rem;
        height: 1.2rem;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 2px solid #ffffff;
        border-radius: 50%;
        border-right-color: transparent;
        animation: spin 3s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
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
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-content {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .spinner {
        width: 3rem;
        height: 3rem;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #212529;
        border-radius: 50%;
        margin: 0 auto 1rem;
        animation: spin 1s linear infinite;
    }

    .loading-text {
        color: #212529;
        font-size: 1.1rem;
        margin: 0;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
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

        <form id="loginForm" method="POST" action="<?php echo URL_ROOT; ?>/auth/login">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-login w-100">
                Login
            </button>
        </form>

        <div class="links auth-footer">
            <a href="<?php echo URL_ROOT; ?>/auth/signup">Don't have an account? Sign up</a>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-content">
        <div class="spinner"></div>
        <p class="loading-text">Logging in...</p>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault(); 
    const overlay = document.getElementById('loadingOverlay');
    overlay.style.display = 'flex';
    
    setTimeout(() => {
        this.submit();
    }, 3000); 
});

</script>
 