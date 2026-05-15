<?php
session_start();
include 'connect.php';

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Records | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Adoption Records</h2>
                <p class="text-secondary small">Track successful pet placements</p>
            </div>
            <a href="add_adoption.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Record New Adoption</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Animal</th>
                            <th>Adopter</th>
                            <th>Adoption Date</th>
                            <th>Recorded By</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-emerald">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="fw-bold"><?php echo $row['animal_name']; ?></div>
                                </div>
                            </td>
                            <td><?php echo $row['fname'] . ' ' . $row['lname']; ?></td>
                            <td><span class="text-muted small"><?php echo date('M d, Y', strtotime($row['adoptiondate'])); ?></span></td>
                            <td><span class="badge bg-light text-dark fw-normal border"><?php echo $row['recorded_by']; ?></span></td>
                            <td class="text-end">
                                <a href="edit_adoption.php?id=<?php echo $row['adoption_id']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?adopt_id=<?php echo $row['adoption_id']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure?')">
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
