<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4"><?= isset($student) ? 'Edit' : 'Add' ?> Student Registration Form</h2>

        <form id="studentForm" enctype="multipart/form-data" class="needs-validation" novalidate>

            <input type="hidden" id="student_id" name="student_id" value="<?= isset($student) ? $student['id'] : ''; ?>">

            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" class="form-control" id="student_name" name="student_name" 
                       value="<?= isset($student) ? $student['student_name'] : ''; ?>" required>
                <div class="invalid-feedback">Please enter the student's name.</div>
            </div>

            <div class="form-group">
                <label for="father_name">Father's Name:</label>
                <input type="text" class="form-control" id="father_name" name="father_name" 
                       value="<?= isset($student) ? $student['father_name'] : ''; ?>" required>
                <div class="invalid-feedback">Please enter the father's name.</div>
            </div>

            <div class="form-group">
                <label for="mother_name">Mother's Name:</label>
                <input type="text" class="form-control" id="mother_name" name="mother_name" 
                       value="<?= isset($student) ? $student['mother_name'] : ''; ?>" required>
                <div class="invalid-feedback">Please enter the mother's name.</div>
            </div>

            <div class="form-group">
                <label for="class">Class:</label>
                <input type="text" class="form-control" id="class" name="class" 
                       value="<?= isset($student) ? $student['class'] : ''; ?>" required>
                <div class="invalid-feedback">Please enter the class.</div>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="male" name="gender" value="Male" 
                           <?= (isset($student) && $student['gender'] == 'Male') ? 'checked' : ''; ?> required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="female" name="gender" value="Female" 
                           <?= (isset($student) && $student['gender'] == 'Female') ? 'checked' : ''; ?> required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
                <div class="invalid-feedback">Please select a gender.</div>
            </div>

            <div class="form-group">
                <label for="photo">Photograph:</label>
                <input type="file" class="form-control-file" id="photo" name="photo">
                <div class="invalid-feedback">Please upload a photo.</div>
                <?php if (isset($student) && $student['photo']): ?>
                    <img src="<?= base_url('writable/uploads/' . $student['photo']); ?>" alt="Student Photo" 
                         class="img-thumbnail mt-2" style="max-width: 100px;">
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="registration_no">Registration No:</label>
                <input type="text" class="form-control" id="registration_no" name="registration_no" 
                       value="<?= isset($student) ? $student['registration_no'] : ''; ?>" required>
                <div class="invalid-feedback">Please enter the registration number.</div>
            </div>

            <div class="form-group">
                <label>Section:</label><br>
                <?php 
                $section = ['A1', 'A2', 'A3', 'A4'];
                foreach ($section as $section): 
                ?>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" id="<?= strtolower($section); ?>" 
                               name="section[]" value="<?= $section; ?>" 
                               <?= (isset($student) && in_array($section, explode(', ', $student['section']))) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="<?= strtolower($section); ?>"><?= $section; ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="btn btn-primary"><?= isset($student) ? 'Update' : 'Submit' ?></button>
        </form>
    </div>

    <script>
    $(document).ready(function() {
        $('#studentForm').on('submit', function(e) {
            e.preventDefault(); 
            var formData = new FormData(this);
            var url = '/student/upload'; // Default to create
            var studentId = $('#student_id').val();
            if (studentId) {
                url += '/' + studentId; // Update existing student
            }
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert('Form Submitted: ' + response); 
                    window.location.href = '/student/list'; // Redirect to the list after submission
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        alert("Error: " + Object.values(errors).join("\n"));
                    } else {
                        alert('There was an error submitting the form');
                    }
                }
            });
        });
    });
    </script>

</body>
</html>
