<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">User Management</h2>
                <p class="text-secondary small">Manage system administrators and staff</p>
            </div>
            <a href="add_user.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add New User</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>User Details</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-primary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo $row['username']; ?></div>
                                        <div class="text-muted small"><?php echo $row['fullname']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $row['role'] == 'admin' ? 'info' : 'secondary'; ?> rounded-pill">
                                    <?php echo ucfirst($row['role']); ?>
                                </span>
                            </td>
                            <td class="text-muted small"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="edit_user.php?uid=<?php echo $row['uid']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?uid=<?php echo $row['uid']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
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
