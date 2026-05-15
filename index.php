<?php
session_start(); 
include "connect.php";

if ($_POST) {
    $user = mysqli_real_escape_string($connection, $_POST['user']);
    $pass = $_POST['pass']; 

    $query = "SELECT * FROM users WHERE username='$user'";
    $res = mysqli_query($connection, $query);
    
    if ($res && $row = mysqli_fetch_assoc($res)) {
        if (password_verify($pass, $row['password'])) {
            $_SESSION['name'] = $row['fullname'];
            $_SESSION['uid'] = $row['uid'];

            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Username or password is wrong');</script>";
        }
    } else {
        echo "<script>alert('Username or password is wrong');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login | Pet Shelter</title>
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);">

    <div class="card login-card p-4 shadow-lg" style="width: 400px; border-radius: 1.5rem;">
        <div class="text-center mb-4">
            <div class="bg-primary text-white d-inline-block p-3 rounded-circle mb-3 shadow">
                <i class="fas fa-paw fa-2x"></i>
            </div>
            <h3 class="fw-bold">Welcome Back</h3>
            <p class="text-muted small">Please enter your credentials to login</p>
        </div>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label small fw-semibold text-secondary">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                    <input name="user" type="text" class="form-control bg-light border-start-0" placeholder="Enter username" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold text-secondary">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                    <input name="pass" type="password" class="form-control bg-light border-start-0" placeholder="Enter password" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2 shadow-sm">
                Login <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>
    </div>

</body>
</html>