<?php
session_start();
include 'connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Medical Records</h2>
                <p class="text-secondary small">Comprehensive health history for all animals</p>
            </div>
            <a href="add_medical_record.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add Medical Record</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Visit Type</th>
                            <th>Diagnosis & Treatment</th>
                            <th>Treated By</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-rose">
                                        <i class="fas fa-file-medical"></i>
                                    </div>
                                    <div class="fw-bold"><?php echo $row['animal_name']; ?></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark fw-normal border"><?php echo $row['visit_type']; ?></span></td>
                            <td>
                                <div class="small fw-semibold"><?php echo $row['diagnoses']; ?></div>
                                <div class="text-muted small"><?php echo $row['treatment']; ?></div>
                            </td>
                            <td><span class="text-muted small"><?php echo $row['treatedBy']; ?></span></td>
                            <td><span class="text-muted small"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span></td>
                            <td class="text-end">
                                <a href="edit_medical_record.php?id=<?php echo $row['record_id']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?rec_id=<?php echo $row['record_id']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure?')">
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
