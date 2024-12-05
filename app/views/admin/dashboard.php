<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
  
    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Students</h6>
                            <h2 class="mb-0"><?= $totalStudents ?></h2>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Books</h6>
                            <h2 class="mb-0"><?= $totalBooks ?></h2>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Active Borrows</h6>
                            <h2 class="mb-0"><?= $activeBorrows ?></h2>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-bookmark-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Overdue Books</h6>
                            <h2 class="mb-0"><?= htmlspecialchars($overdueBorrows) ?></h2>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Borrows Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Current Borrows</h5>
            <button class="btn btn-link btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#borrowsTable">
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
        <div class="collapse show" id="borrowsTable">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Book Title</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentBorrows)): ?>
                                <?php foreach ($recentBorrows as $borrow): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($borrow['student_name']); ?></td>
                                        <td><?php echo htmlspecialchars($borrow['book_title']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($borrow['borrow_date'])); ?></td>
                                        <td><?php echo isset($borrow['return_date']) ? date('M d, Y', strtotime($borrow['return_date'])) : 'N/A'; ?></td>
                                        <td>
                                            <span class="badge 
                                                <?php 
                                                    if ($borrow['borrow_status'] === 'OVERDUE') {
                                                        echo 'bg-danger'; // Red for overdue
                                                    } elseif ($borrow['borrow_status'] === 'BORROWED') {
                                                        echo 'bg-success'; // Green for borrowed
                                                    } elseif ($borrow['borrow_status'] === 'returned') {
                                                        echo 'bg-warning'; // Yellow for returned
                                                    }
                                                ?>">
                                                <?php echo htmlspecialchars($borrow['borrow_status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No active borrows found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

    // Check for saved sidebar state
    if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        document.body.classList.add('sb-sidenav-toggled');
    }
});
</script>

 