<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT mr.*, a.name AS animal_name 
          FROM medical_record mr
          JOIN animals a ON mr.animal_id = a.animal_id
          ORDER BY mr.created_at DESC";

$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical Records</title>
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
            <h2>Medical Records</h2>
            <a href="add_medical_record.php" class="btn btn-success">+ Add Medical Record</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Animal</th>
                            <th>Visit Type</th>
                            <th>Treatment</th>
                            <th>Diagnosis</th>
                            <th>Treated By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><strong><?php echo $row['animal_name']; ?></strong></td>
                            <td><?php echo $row['visit_type']; ?></td>
                            <td><?php echo $row['treatment']; ?></td>
                            <td><?php echo $row['diagnoses']; ?></td>
                            <td><?php echo $row['treatedBy']; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="deletes.php?rec_id=<?php echo $row['record_id']; ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this medical record?')">Delete</a>
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
