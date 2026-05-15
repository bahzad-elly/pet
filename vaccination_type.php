<?php
session_start();
include 'connect.php';

//check for security . 
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$result = mysqli_query($connection,"SELECT * From vaccination_types");
/*
CRUD 
create
read
update
delete

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vaccine Types | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Vaccine Library</h2>
                <p class="text-secondary small">Define and manage available vaccination types</p>
            </div>
            <a href="add_vaccines.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add New Vaccine</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Vaccine Name</th>
                            <th>Description</th>
                            <th>Frequency</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($array = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-info">
                                        <i class="fas fa-vial"></i>
                                    </div>
                                    <div class="fw-bold"><?php echo $array['vaccine_name']; ?></div>
                                </div>
                            </td>
                            <td><span class="text-muted small"><?php echo $array['description']; ?></span></td>
                            <td><span class="badge bg-light text-dark fw-normal border">Every <?php echo $array['frequency_months']; ?> Months</span></td>
                            <td class="text-end">
                                <a href="edit_vaccine_type.php?id=<?php echo $array['vtype_id']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?vid=<?php echo $array['vtype_id']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure?')">
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