<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT ad.adoption_id, a.name AS animal_name, adp.fname, adp.lname, ad.adoptiondate, u.fullname AS recorded_by 
          FROM adoption ad
          JOIN animals a ON ad.animal_id = a.animal_id
          JOIN adopters adp ON ad.adopter_id = adp.adopterId
          LEFT JOIN users u ON ad.user_id = u.uid
          ORDER BY ad.adoptiondate DESC";

$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; padding-top: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px; }
        .sidebar a:hover { background:rgb(12, 194, 244); }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Adoption Records</h2>
            <a href="add_adoption.php" class="btn btn-success">+ Record New Adoption</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Animal Name</th>
                            <th>Adopter Name</th>
                            <th>Adoption Date</th>
                            <th>Recorded By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong><?php echo $row['animal_name']; ?></strong></td>
                            <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>
                            <td><?php echo $row['adoptiondate']; ?></td>
                            <td><?php echo $row['recorded_by']; ?></td>
                            <td>
                                <a href="deletes.php?adopt_id=<?php echo $row['adoption_id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this adoption record?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
