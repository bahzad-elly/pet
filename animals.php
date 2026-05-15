<?php
session_start();
include 'connect.php';

//check for security . 
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// boya left joinman danawa labar way hamu datakan bgarenetawa agar wargrishman nabe hich nishan nadat , wata null bgarenetawa
$result = mysqli_query($connection, "SELECT a.animal_id,a.name,a.species,a.breed,a.age,a.status ,i.sname FROM animals a left join intake_source i on a.intake_id =i.iid; ");

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
    <title>Animal Records | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Animal Records</h2>
                <p class="text-secondary small">Manage and track all animals in the shelter</p>
            </div>
            <a href="add_animals.php" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Add New Animal</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Animal Details</th>
                            <th>Age</th>
                            <th>Intake Source</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($array = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-primary">
                                        <i class="fas fa-paw"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo $array['name']; ?></div>
                                        <div class="text-muted small"><?php echo $array['species']; ?> • <?php echo $array['breed']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $array['age']; ?> Years</td>
                            <td><span class="text-muted small"><?php echo $array['sname']; ?></span></td>
                            <td>
                                <span class="badge rounded-pill <?php 
                                    echo $array['status'] == 'Available' ? 'bg-info' : 
                                        ($array['status'] == 'Adopted' ? 'bg-success' : 'bg-warning'); 
                                ?>">
                                    <?php echo $array['status']; ?>
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="edit_animal.php?id=<?php echo $array['animal_id']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?id=<?php echo $array['animal_id']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Are you sure?')">
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