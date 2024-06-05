<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Toggle Button</title>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
</head>
<body><!-- View/Edit Student Modal -->
<div class="modal fade" id="studentViewEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateStudent">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                    <input type="hidden" name="student_id" id="student_id">

                    <div class="mb-3">
                        <label for="">Name</label>
                        <p id="view_name" class="form-control view-mode"></p>
                        <input type="text" name="name" id="edit_name" class="form-control edit-mode d-none" />
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <p id="view_email" class="form-control view-mode"></p>
                        <input type="text" name="email" id="edit_email" class="form-control edit-mode d-none" />
                    </div>
                    <div class="mb-3">
                        <label for="">Phone</label>
                        <p id="view_phone" class="form-control view-mode"></p>
                        <input type="text" name="phone" id="edit_phone" class="form-control edit-mode d-none" />
                    </div>
                    <div class="mb-3">
                        <label for="">Course</label>
                        <p id="view_course" class="form-control view-mode"></p>
                        <input type="text" name="course" id="edit_course" class="form-control edit-mode d-none" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="toggleEditBtn" class="btn btn-secondary">Edit</button>
                    <button type="submit" class="btn btn-primary d-none edit-mode">Update Student</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>PHP Ajax CRUD without page reload using Bootstrap Modal
                        
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                            Add Student
                        </button>
                    </h4>
                </div>
                <div class="card-body">

                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                                require 'config/db.php';

                                $query = "SELECT * FROM students";
                                $stmt = $con->query($query);

                                while ($student = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $student['id'] ?></td>
                                        <td><?= $student['name'] ?></td>
                                        <td><?= $student['email'] ?></td>
                                        <td><?= $student['phone'] ?></td>
                                        <td><?= $student['course'] ?></td>
                                        <td>
                                            <button type="button" value="<?=$student['id'];?>" class="editStudentBtn btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="studentViewEditModal">Edit</button>
                                            <button type="button" value="<?=$student['id'];?>" class="deleteStudentBtn btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Delete</button>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
    $(document).ready(function() {
    var studentIdToDelete;

    // Function to toggle edit mode
    function toggleEditMode() {
        $('.view-mode').toggleClass('d-none');
        $('.edit-mode').toggleClass('d-none');
        if ($('.edit-mode').hasClass('d-none')) {
            $('#toggleEditBtn').text('Edit');
        } else {
            $('#toggleEditBtn').text('View');
        }
    }

    // Handle edit button click
    $('#toggleEditBtn').click(function() {
        toggleEditMode();
    });

    // Handle view and edit button clicks
    $(document).on('click', '.viewStudentBtn, .editStudentBtn', function() {
        var student_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "code.php?student_id=" + student_id,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 404) {
                    alert(res.message);
                } else if (res.status == 200) {
                    $('#student_id').val(res.data.id);
                    $('#view_name').text(res.data.name);
                    $('#view_email').text(res.data.email);
                    $('#view_phone').text(res.data.phone);
                    $('#view_course').text(res.data.course);
                    $('#edit_name').val(res.data.name);
                    $('#edit_email').val(res.data.email);
                    $('#edit_phone').val(res.data.phone);
                    $('#edit_course').val(res.data.course);

                    $('#studentViewEditModal').modal('show');

                    // If the edit button was clicked, switch to edit mode
                    if ($(this).hasClass('editStudentBtn')) {
                        toggleEditMode();
                    }
                }
            }
        });
    });

    // Handle update form submission
    $(document).on('submit', '#updateStudent', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("update_student", true);

        $.ajax({
            type: "POST",
            url: "code.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#errorMessageUpdate').removeClass('d-none');
                    $('#errorMessageUpdate').text(res.message);
                } else if (res.status == 200) {
                    $('#errorMessageUpdate').addClass('d-none');
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);

                    $('#studentViewEditModal').modal('hide');
                    $('#updateStudent')[0].reset();
                    $('#myTable').load(location.href + " #myTable");
                } else if (res.status == 500) {
                    alert(res.message);
                }
            }
        });
    });

    // Handle delete button click in edit mode
    $('#deleteStudentBtn').click(function() {
        studentIdToDelete = $('#student_id').val();
        $('#deleteConfirmationModal').modal('show');
    });

    // Handle confirm delete button click
    $('#confirmDeleteBtn').click(function() {
        $.ajax({
            type: "POST",
            url: "code.php",
            data: {
                'delete_student': true,
                'student_id': studentIdToDelete
            },
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 200) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success('Record deleted successfully.');

                    // Remove the deleted student row from the table
                    $('button.deleteStudentBtn[value="' + studentIdToDelete + '"]').closest('tr').remove();
                    $('#deleteConfirmationModal').modal('hide');
                    $('#studentViewEditModal').modal('hide');
                } else {
                    alert('Failed to delete record.');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('An error occurred while trying to delete the record.');
            }
        });
    });
});

</script>

</body>
</html>
