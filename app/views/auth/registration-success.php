<?php require APP_PATH . '/views/layouts/header.php'; ?>

<style>
    .success-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        padding: 2rem;
    }

    .success-card {
        background: #fff;
        padding: 3rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        max-width: 500px;
        width: 100%;
    }

    .success-icon {
        font-size: 4rem;
        color: #198754;
        margin-bottom: 1rem;
    }

    .success-title {
        font-size: 1.75rem;
        margin-bottom: 1rem;
        color: #212529;
    }

    .success-message {
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .redirect-message {
        color: #6c757d;
        font-size: 0.9rem;
    }
</style>

<div class="success-wrapper">
    <div class="success-card">
        <i class="bi bi-check-circle-fill success-icon"></i>
        <h1 class="success-title">Registration Successful!</h1>
        <p class="success-message">Your account has been created successfully.</p>
        <p class="redirect-message">Redirecting to login page in <span id="countdown">3</span> seconds...</p>
    </div>
</div>

<script>
    let seconds = 3;
    const countdownDisplay = document.getElementById('countdown');
    
    const countdown = setInterval(() => {
        seconds--;
        countdownDisplay.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdown);
            window.location.href = '<?= URL_ROOT ?>/auth/login';
        }
    }, 3000);
</script>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 