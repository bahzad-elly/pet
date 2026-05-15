<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM medical_record WHERE record_id = $id";
$res = mysqli_query($connection, $query);
$record = mysqli_fetch_assoc($res);

$animals = mysqli_query($connection, "SELECT * FROM animals");

if ($_POST) {
    $animal_id = (int)$_POST['animal_id'];
    $treatment = mysqli_real_escape_string($connection, $_POST['treatment']);
    $treatedBy = mysqli_real_escape_string($connection, $_POST['treatedBy']);
    $visit_type = mysqli_real_escape_string($connection, $_POST['visit_type']);
    $diagnoses = mysqli_real_escape_string($connection, $_POST['diagnoses']);

    $sql = "UPDATE medical_record SET 
            animal_id=$animal_id, 
            treatment='$treatment', 
            treatedBy='$treatedBy', 
            visit_type='$visit_type', 
            diagnoses='$diagnoses' 
            WHERE record_id=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: medical_record.php");
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
    <title>Edit Medical Record | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Medical Record</h2>
            <p class="text-secondary small">Update health record details</p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Animal</label>
                        <select name="animal_id" class="form-select" required>
                            <?php while($a = mysqli_fetch_assoc($animals)): ?>
                                <option value="<?php echo $a['animal_id']; ?>" <?php echo $record['animal_id'] == $a['animal_id'] ? 'selected' : ''; ?>>
                                    <?php echo $a['name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Visit Type</label>
                            <input type="text" name="visit_type" class="form-control" value="<?php echo $record['visit_type']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Treated By</label>
                            <input type="text" name="treatedBy" class="form-control" value="<?php echo $record['treatedBy']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Diagnosis</label>
                        <textarea name="diagnoses" class="form-control" rows="2" required><?php echo $record['diagnoses']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Treatment Provided</label>
                        <textarea name="treatment" class="form-control" rows="3" required><?php echo $record['treatment']; ?></textarea>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Medical Record</button>
                        <a href="medical_record.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
