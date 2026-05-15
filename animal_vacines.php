<?php
session_start();
include 'connect.php';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Vaccination History | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Vaccination History</h2>
                <p class="text-secondary small">Track all vaccines administered to animals</p>
            </div>
            <a href="add_animal_vaccines.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Record Vaccination</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Vaccine Type</th>
                            <th>Date Administered</th>
                            <th>Next Due Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-info">
                                        <i class="fas fa-syringe"></i>
                                    </div>
                                    <div class="fw-bold"><?php echo $row['animal_name']; ?></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark fw-normal border"><?php echo $row['vaccine_name']; ?></span></td>
                            <td><span class="text-muted small"><?php echo date('M d, Y', strtotime($row['date'])); ?></span></td>
                            <td><span class="text-danger fw-medium small"><?php echo date('M d, Y', strtotime($row['nextDate'])); ?></span></td>
                            <td class="text-end">
                                <a href="edit_animal_vaccine.php?id=<?php echo $row['av_id']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?av_id=<?php echo $row['av_id']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Delete this record?')">
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