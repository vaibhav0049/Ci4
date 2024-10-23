<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($article) ? 'Edit Article' : 'Add Article' ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2><?= isset($article) ? 'Edit Article' : 'Add New Article' ?></h2>
    
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('articles/save') ?>" method="POST">
        <?php if (isset($article)): ?>
            <input type="hidden" name="id" value="<?= esc($article['id']) ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?= isset($article) ? esc($article['full_name']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= isset($article) ? esc($article['phone_number']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="email_address">Email Address:</label>
            <input type="email" class="form-control" id="email_address" name="email_address" value="<?= isset($article) ? esc($article['email_address']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="email_address">User Id </label>
            <input type="text" class="form-control" id="user_id" name="user_id" value="<?= isset($article) ? esc($article['user_id']) : '' ?>" >
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= site_url('articles/list') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
