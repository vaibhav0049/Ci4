
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <h2 class="mb-4">Student List</h2>
        <a href="<?= site_url('student/form'); ?>" class="btn btn-primary mb-3">Add New Student</a>
        <form action="<?= site_url('student/list') ?>" method="GET" class="form-inline mb-3">
        <input type="text" name="search" class="form-control mr-sm-2" placeholder="Search by Name, father's name or registration_no" value="<?= esc($search ?? '') ?>">
        <button type="submit" class="btn btn-success">Search</button>
        <a href="<?= site_url('student/list') ?>" class="btn btn-secondary ml-2">Reset</a>
    </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Father's Name</th>
                    <th>Mother's Name</th>
                    <th>Class</th>
                    <th>Gender</th>
                    <th>Registration No</th>
                    <th>Section</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['id']; ?></td>
                    <td><?= $student['student_name']; ?></td>
                    <td><?= $student['father_name']; ?></td>
                    <td><?= $student['mother_name']; ?></td>
                    <td><?= $student['class']; ?></td>
                    <td><?= $student['gender']; ?></td>
                    <td><?= $student['registration_no']; ?></td>
                    <td><?= $student['section']; ?></td>
                    
                    <td>
                        <a href="<?= site_url('student/form/' . $student['id']); ?>" class="btn btn-warning">Edit</a>
                        <button class="btn btn-danger delete-student" data-id="<?= $student['id']; ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?= $pager->links() ?> 
    </div>

    <script>
        $(document).on('click', '.delete-student', function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this student?')) {
                $.ajax({
                    url: '/student/delete/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        alert('Student deleted successfully');
                        location.reload();
                    },
                    error: function() {
                        alert('Failed to delete the student');
                    }
                });
            }
        });
    </script>
</body>

</html>
