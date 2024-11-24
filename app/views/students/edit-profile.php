<?php 
function flash($name) {
    if(isset($_SESSION[$name])) {
        echo '<div class="alert alert-success">'.$_SESSION[$name].'</div>';
        unset($_SESSION[$name]);
    }
}

require APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h2>Edit Profile</h2>
    
    <?php flash('profile_message'); ?>
    
    <form action="<?php echo isset($URLROOT) ? $URLROOT : ''; ?>/students/updateProfile" method="POST">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" 
                value="<?php echo $data['student']->name; ?>">
        </div>
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" 
                value="<?php echo $data['student']->email; ?>">
        </div>
        
        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" 
                value="<?php echo $data['student']->phone; ?>">
        </div>
        
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?> 