<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])){
     header("Location: index.php");
     exit();
}


$sources_query = mysqli_query($connection, "SELECT iid, sname FROM intake_source");

if ($_POST) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $status = $_POST['status'];
    $intake_id = $_POST['intake_id'];


    $sql = "INSERT INTO animals (name, species, breed, age, status, intake_id) 
            VALUES ('$name', '$species', '$breed', '$age', '$status', '$intake_id')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: animals.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Animal | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Add New Animal</h2>
            <p class="text-secondary small">Register a new animal into the shelter system</p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Animal Name</label>
                            <input name="name" class="form-control" placeholder="e.g. Buddy" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Species</label>
                            <input name="species" class="form-control" placeholder="e.g. Dog" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Breed</label>
                            <input name="breed" class="form-control" placeholder="e.g. Golden Retriever">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Age (Years)</label>
                            <input type="number" name="age" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Intake Source</label>
                        <select name="intake_id" class="form-select" required>
                            <option value="">-- Select Source --</option>
                            <?php while($row = mysqli_fetch_assoc($sources_query)): ?>
                                <option value="<?php echo $row['iid']; ?>">
                                    <?php echo $row['sname']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-secondary">Initial Status</label>
                        <select name="status" class="form-select">
                            <option value="Available">Available</option>
                            <option value="Medical Care">Medical Care</option>
                            <option value="Adopted">Adopted</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Save Animal Record</button>
                        <a href="animals.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>