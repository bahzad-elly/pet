<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])){
     header("Location: index.php");
     exit();
}




if ($_POST) {
    $vaccine = $_POST['name'];
    $description = $_POST['desc'];
    $frequency_months = $_POST['month'];


    $sql = "INSERT INTO vaccination_types (vaccine_name, description, frequency_months) 
            VALUES ('$vaccine', '$description', '$frequency_months')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: vaccination_type.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; padding-top: 20px; background: #212529; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px; }
        .sidebar a:hover { background:rgb(12, 194, 244); }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">Add Vaccine</div>
            <div class="card-body">
                <form method="POST">
                    <input name="name" class="form-control mb-2" placeholder="Name" required>
                    <input name="desc" class="form-control mb-2" placeholder="Description" required>
                    <input type="number" name="month" class="form-control mb-2" placeholder="Frequency (Months)" required>
                    

                    <button type="submit" class="btn btn-success w-100">Save vaccine</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>