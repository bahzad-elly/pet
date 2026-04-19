<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$result = mysqli_query($connection, "SELECT * FROM adopters ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Adopters</title>
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
            <h2>Adopters</h2>
            <a href="add_adopter.php" class="btn btn-success">+ Add New Adopter</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Preference</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong><?php echo $row['fname'] . ' ' . $row['lname']; ?></strong></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['preference']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="deletes.php?adp_id=<?php echo $row['adopterId']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this adopter?')">Delete</a>
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
