<footer class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="<?php echo URL_ROOT; ?>/auth/login">Browse Books</a></li>
                <li><a href="#" onclick="return false;">My Profile</a></li>
                <li><a href="#" onclick="return false;">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Contact Info</h3>
            <ul>
                <li><i class="bi bi-envelope"></i> library@example.com</li>
                <li><i class="bi bi-telephone"></i> (123) 456-7890</li>
                <li><i class="bi bi-geo-alt"></i> 123 Library Street</li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-links">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> Library Management System. All rights reserved.</p>
    </div>
</footer>

<style>
    html, body {
        min-height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    main {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .footer {
        background-color: #000;
        color: #fff;
        padding: 2rem 0 0.5rem 0;
        width: 100%;
        margin-top: auto;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 0 2rem;
    }

    .footer-section h3 {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 0.3rem;
    }

    .footer-section h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background-color: #fff;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-section ul li {
        margin-bottom: 0.5rem;
    }

    .footer-section ul li a {
        color: #fff;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .footer-section ul li a:hover {
        opacity: 0.7;
    }

    .footer-section i {
        margin-right: 10px;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        color: #fff;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .social-links a:hover {
        transform: translateY(-3px);
    }

    .footer-bottom {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-bottom p {
        margin: 0;
        font-size: 0.9rem;
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 1.5rem;
            padding: 0 1rem;
        }

        .footer-section h3::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .social-links {
            justify-content: center;
        }

        .footer {
            padding: 1.5rem 0 0.5rem 0;
        }

        .footer-section h3 {
            margin-bottom: 0.8rem;
        }

        .footer-bottom {
            margin-top: 1rem;
            padding-top: 0.8rem;
        }
    }

    .table-container {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-bottom: 0;
    }

    .table-scroll {
        flex: 1;
        margin-bottom: 0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</script>
</body>

</html>