<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
     
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination li {
            list-style-type: none;
            margin: 0 5px;
        }

        .pagination li a {
            text-decoration: none;
            padding: 8px 16px;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .pagination li a:hover {
            background-color: #f1f1f1;
        }

        .pagination li.active a {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination li.disabled a {
            color: #6c757d;
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Articles List</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <a href="<?= site_url('articles/form') ?>" class="btn btn-primary mb-3">Add New Article</a>
    <a href="<?= site_url('/') ?>" class="btn btn-danger mb-3">Logout</a>

    <form action="<?= site_url('articles/list') ?>" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by Name, Phone or Email" value="<?= esc($search ?? '') ?>">
        <button type="submit" class="btn btn-success">Search</button>
        <a href="<?= site_url('articles/list') ?>" class="btn btn-secondary ml-2">Reset</a>
    </form>

    <?php if (!empty($article)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($article as $article): ?>
                    <tr>
                        <td><?= esc($article['id']) ?></td>
                        <td><?= esc($article['user_id']) ?></td>
                        <td><?= esc($article['full_name']) ?></td>
                        <td><?= esc($article['phone_number']) ?></td>
                        <td><?= esc($article['email_address']) ?></td>
                        <td><?= esc($article['status']) ?></td>
                        <td>
                            <a href="<?= site_url('articles/form/'.$article['id']) ?>" class="btn btn-warning">Edit</a>
                            <?php if ($article['status']): ?>
                                <a href="<?= site_url('articles/delete/'.$article['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        
        <?= $pager->links() ?> 
        
    <?php else: ?>
        <p>No articles found.</p>
    <?php endif; ?>
</div>
</body>
</html>
