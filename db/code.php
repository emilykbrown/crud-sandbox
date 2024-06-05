<?php
require 'config/db.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $query = "SELECT * FROM students WHERE id = :id LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->execute([':id' => $student_id]);

    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 200, 'data' => $student]);
    } else {
        echo json_encode(['status' => 404, 'message' => 'Student Not Found']);
    }
    exit();
}

if (isset($_POST['save_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $query = "INSERT INTO students (name, email, phone, course) VALUES (:name, :email, :phone, :course)";
    $stmt = $con->prepare($query);
    $stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':course' => $course]);

    if ($stmt) {
        echo json_encode(['status' => 200, 'message' => 'Student Added Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Student Not Added']);
    }
    exit();
}

if (isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];

    $query = "UPDATE students SET name = :name, email = :email, phone = :phone, course = :course WHERE id = :id";
    $stmt = $con->prepare($query);
    $stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':course' => $course, ':id' => $student_id]);

    if ($stmt) {
        echo json_encode(['status' => 200, 'message' => 'Student Updated Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Student Not Updated']);
    }
    exit();
}

if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];

    $query = "DELETE FROM students WHERE id = :id";
    $stmt = $con->prepare($query);
    $stmt->execute([':id' => $student_id]);

    if ($stmt) {
        echo json_encode(['status' => 200, 'message' => 'Student Deleted Successfully']);
    } else {
        echo json_encode(['status' => 500, 'message' => 'Student Not Deleted']);
    }
    exit();
}
?>
