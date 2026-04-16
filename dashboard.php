<?php
include "connect.php";
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();

    }
$animals = mysqli_query($connection , "SELECT count(*) as totalAnimal FROm animals");
$total_animals = mysqli_fetch_assoc($animals);


$users = mysqli_query($connection , "SELECT count(*) as totalusers FROm users");
$total_users = mysqli_fetch_assoc($users);

$adopters = mysqli_query($connection , "SELECT count(*) as totaladops FROm adoption");
$adops = mysqli_fetch_assoc($adopters);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Shelter Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.sidebar { 
height: 100vh; 
width: 250px;
position: fixed;
padding-top: 20px; 
}
.sidebar a {
color: white;
text-decoration: none;
display: block;
padding: 15px; 
}
.sidebar a:hover { 
background:rgb(12, 194, 244);
}
.main-content {
margin-left: 250px;
padding: 30px; 
}
</style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="card p-4 shadow-sm">
            <h2>Welcome, <?php echo $_SESSION['name']; ?>!</h2>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white p-3 text-center">
                        <h5>Animals</h5>
                        <h3><?php echo $total_animals['totalAnimal']; ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white p-3 text-center">
                        <h5>Adoptions</h5>
                        <h3><?php echo $adops['totaladops']; ?></h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-dark p-3 text-center">
                        <h5>Users</h5>
                        <h3><?php echo $total_users['totalusers']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>