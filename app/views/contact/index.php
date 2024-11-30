<?php require APP_PATH . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Contact Us</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Get in Touch</h5>
                    <p><i class="bi bi-geo-alt-fill me-2"></i>123 Library Street, Ijebu Ode, Nigeria</p>
                    <p><i class="bi bi-envelope-fill me-2"></i>library@example.com</p>
                    <p><i class="bi bi-telephone-fill me-2"></i>+234 807 543 8900</p>
                    <p><i class="bi bi-clock-fill me-2"></i>Monday - Friday: 8:00 AM - 8:00 PM</p>
                    <p class="mb-0"><i class="bi bi-calendar-fill me-2"></i>Saturday: 9:00 AM - 5:00 PM</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Send us a Message</h5>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/footer.php'; ?> 