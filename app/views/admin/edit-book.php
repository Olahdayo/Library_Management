<?php require APP_PATH . '/views/layouts/admin-header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Book</h2>
                </div>
                <div class="card-body">
                    <form action="<?= URL_ROOT ?>/admin/editBook/<?= $data['id'] ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $data['id'] ?>">
                        
                        <div class="form-group mb-3">
                            <label for="title">Title: <sup>*</sup></label>
                            <input type="text" name="title" 
                                   class="form-control <?= !empty($data['title_err']) ? 'is-invalid' : '' ?>"
                                   value="<?= $data['title'] ?>">
                            <span class="invalid-feedback"><?= $data['title_err'] ?></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="author">Author: <sup>*</sup></label>
                            <input type="text" name="author" 
                                   class="form-control <?= !empty($data['author_err']) ? 'is-invalid' : '' ?>"
                                   value="<?= $data['author'] ?>">
                            <span class="invalid-feedback"><?= $data['author_err'] ?></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="isbn">ISBN: <sup>*</sup></label>
                            <input type="text" name="isbn" 
                                   class="form-control <?= !empty($data['isbn_err']) ? 'is-invalid' : '' ?>"
                                   value="<?= $data['isbn'] ?>">
                            <span class="invalid-feedback"><?= $data['isbn_err'] ?></span>
                        </div>

                        <div class="form-group mb-3">
                            <label for="available_copies">Available Copies: <sup>*</sup></label>
                            <input type="number" name="available_copies" 
                                   class="form-control <?= !empty($data['available_copies_err']) ? 'is-invalid' : '' ?>"
                                   value="<?= $data['available_copies'] ?>">
                            <span class="invalid-feedback"><?= $data['available_copies_err'] ?></span>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="submit" value="Update Book" class="btn btn-success btn-block">
                            </div>
                            <div class="col">
                                <a href="<?= URL_ROOT ?>/admin/books" class="btn btn-light btn-block">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APP_PATH . '/views/layouts/admin-footer.php'; ?> 