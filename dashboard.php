<?php
session_start();
include "connect.php";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="header mb-4">
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <p class="text-secondary">Welcome back, <span class="text-primary fw-semibold"><?php echo $_SESSION['name']; ?></span>!</p>
        </div>
        
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <a href="animals.php" class="stat-card bg-indigo">
                    <div>
                        <i class="fas fa-dog fa-2x mb-3 opacity-75"></i>
                        <p>Total Animals</p>
                    </div>
                    <h3><?php echo $total_animals['totalAnimal']; ?></h3>
                </a>
            </div>
            <div class="col-md-4">
                <a href="adoption.php" class="stat-card bg-emerald">
                    <div>
                        <i class="fas fa-heart fa-2x mb-3 opacity-75"></i>
                        <p>Successful Adoptions</p>
                    </div>
                    <h3><?php echo $adops['totaladops']; ?></h3>
                </a>
            </div>
            <div class="col-md-4">
                <a href="users.php" class="stat-card bg-amber">
                    <div>
                        <i class="fas fa-user-shield fa-2x mb-3 opacity-75"></i>
                        <p>Registered Users</p>
                    </div>
                    <h3><?php echo $total_users['totalusers']; ?></h3>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-4 h-100">
                    <h5 class="fw-bold mb-4">Recent Activity</h5>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-history fa-3x mb-3 opacity-25"></i>
                        <p>No recent activity to display.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100">
                    <h5 class="fw-bold mb-4">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="add_animals.php" class="btn btn-outline-primary text-start"><i class="fas fa-plus-circle me-2"></i> Register New Animal</a>
                        <a href="add_adopter.php" class="btn btn-outline-success text-start"><i class="fas fa-user-plus me-2"></i> Register New Adopter</a>
                        <a href="add_adoption.php" class="btn btn-outline-info text-start"><i class="fas fa-hand-holding-heart me-2"></i> Process Adoption</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>