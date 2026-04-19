<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])) header("Location: index.php");

$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($connection, $sql);
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
        <div class="d-flex justify-content-between mb-4">
            <h2>User Management</h2>
            <a href="add_user.php" class="btn btn-primary btn-sm">+ Add New User</a>
        </div>
        <div class="card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?php echo $row['username']; ?></strong></td>
                        <td><?php echo $row['fullname']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><span class="badge bg-info text-dark"><?php echo $row['role']; ?></span></td>
                        <td>
                            <a href="deletes.php?uid=<?php echo $row['uid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
