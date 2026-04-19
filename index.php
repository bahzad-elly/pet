<?php
include "connect.php";// ama bo henany codakay aw paraya ka daman nawa
session_start(); //bo wargrtni zanyary user bo away server binasetawa

if ($_POST) {
$user = $_POST['user'];
$pass = hash('sha256', $_POST['pass']); 


$res = mysqli_query($connection, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    
    if ($row = mysqli_fetch_assoc($res)) {

        $_SESSION['name'] = $row['fullname'];
        $_SESSION['uid'] = $row['uid'];

        header("Location: dashboard.php");

    } else {

        echo "<script>alert('username or password is wrong');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 shadow-sm" style="width: 650px; height:300px">
        <h4 class="text-center mb-4">Login</h4>
        <form method="POST">
            <input name="user" type="text" class="form-control mb-3" placeholder="Username" required>
            <input name="pass" type="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-primary w-80 m-4">Login</button>
        </form>
    </div>

</body>
</html>