<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])) header("Location: index.php");

//am joinaian kamek sar eshay wist ta tey gashtm , barasty naxosh bu
$sql = "SELECT av.av_id, a.name as animal_name, vt.vaccine_name, av.date, av.nextDate, u.username 
        FROM animal_vaccination av
        JOIN animals a ON av.animal_id = a.animal_id
        JOIN vaccination_types vt ON av.vtype_id = vt.vtype_id
        LEFT JOIN users u ON av.userId = u.uid
        ORDER BY av.date DESC";

$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar
        { height: 100vh; 
        width: 250px; 
        position: fixed; 
        background: #212529; 
        }
        .sidebar a { 
            color: white; 
            text-decoration: none; 
            display: block; 
            padding: 15px; 
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
        <div class="d-flex justify-content-between mb-4">
            <h2>Vaccination History</h2>
            <a href="add_animal_vaccines.php" class="btn btn-primary btn-sm">+ Add New</a>
        </div>
        <div class="card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Animal</th>
                        <th>Vaccine</th>
                        <th>Date Given</th>
                        <th>Next Due</th>
                        <th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo $row['animal_name']; ?></strong></td>
                        <td><?php echo $row['vaccine_name']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td class="text-danger"><?php echo $row['nextDate']; ?></td>
                        <td><span class="badge bg-secondary"><?php echo $row['username']; ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>