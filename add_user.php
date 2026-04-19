<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])) header("Location: index.php");

if ($_POST) {
    $user = $_POST['username'];
    $pass = hash('sha256', $_POST['password']); 
    $fname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, fullname, email, role) 
            VALUES ('$user', '$pass', '$fname', '$email', '$role')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: users.php");
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; background: #212529; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px; }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">Add New User</div>
            <div class="card-body">
                <form method="POST">
                    <label class="small">Username</label>
                    <input type="text" name="username" class="form-control mb-2" required>

                    <label class="small">Password</label>
                    <input type="password" name="password" class="form-control mb-2" required>

                    <label class="small">Full Name</label>
                    <input type="text" name="fullname" class="form-control mb-2" required>

                    <label class="small">Email</label>
                    <input type="email" name="email" class="form-control mb-2" required>

                    <label class="small">Role</label>
                    <select name="role" class="form-select mb-3" required>
                        <option value="staff">Staff</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button class="btn btn-success w-100">Save User</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
