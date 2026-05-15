<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM animals WHERE animal_id = $id";
$res = mysqli_query($connection, $query);
$animal = mysqli_fetch_assoc($res);

$intakes = mysqli_query($connection, "SELECT * FROM intake_source");

if ($_POST) {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $species = mysqli_real_escape_string($connection, $_POST['species']);
    $breed = mysqli_real_escape_string($connection, $_POST['breed']);
    $age = (int)$_POST['age'];
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $intake_id = (int)$_POST['intake_id'];

    $sql = "UPDATE animals SET 
            name='$name', 
            species='$species', 
            breed='$breed', 
            age=$age, 
            gender='$gender', 
            status='$status', 
            intake_id=$intake_id 
            WHERE animal_id=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: animals.php");
        exit();
    } else {
        $error = mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Animal | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Animal</h2>
            <p class="text-secondary small">Update record for <span class="text-primary"><?php echo $animal['name']; ?></span></p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 700px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Animal Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $animal['name']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Species</label>
                            <input type="text" name="species" class="form-control" value="<?php echo $animal['species']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Breed</label>
                            <input type="text" name="breed" class="form-control" value="<?php echo $animal['breed']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Age (Years)</label>
                            <input type="number" name="age" class="form-control" value="<?php echo $animal['age']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-secondary">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="Male" <?php echo $animal['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $animal['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Unknown" <?php echo $animal['gender'] == 'Unknown' ? 'selected' : ''; ?>>Unknown</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-secondary">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="Available" <?php echo $animal['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                                <option value="Adopted" <?php echo $animal['status'] == 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
                                <option value="Pending" <?php echo $animal['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Medical Care" <?php echo $animal['status'] == 'Medical Care' ? 'selected' : ''; ?>>Medical Care</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold text-secondary">Intake Source</label>
                            <select name="intake_id" class="form-select" required>
                                <?php while($i = mysqli_fetch_assoc($intakes)): ?>
                                    <option value="<?php echo $i['iid']; ?>" <?php echo $animal['intake_id'] == $i['iid'] ? 'selected' : ''; ?>>
                                        <?php echo $i['sname']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Animal Record</button>
                        <a href="animals.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
