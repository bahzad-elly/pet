<?php
session_start();
include 'connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopters | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Adopter Records</h2>
                <p class="text-secondary small">Manage and track all registered adopters</p>
            </div>
            <a href="add_adopter.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add New Adopter</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Adopter Name</th>
                            <th>Contact Info</th>
                            <th>Address</th>
                            <th>Preferences</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-primary">
                                        <i class="fas fa-user-tag"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo $row['fname'] . ' ' . $row['lname']; ?></div>
                                        <div class="text-muted small">Registered: <?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><i class="fas fa-phone-alt me-2 text-muted small"></i> <?php echo $row['phone']; ?></td>
                            <td><span class="text-muted small"><?php echo $row['address']; ?></span></td>
                            <td><span class="badge bg-light text-dark fw-normal border"><?php echo $row['preference']; ?></span></td>
                            <td class="text-end">
                                <a href="edit_adopter.php?id=<?php echo $row['adopterId']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?adp_id=<?php echo $row['adopterId']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure?')">
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
