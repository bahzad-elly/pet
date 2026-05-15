<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM animal_vaccination WHERE av_id = $id";
$res = mysqli_query($connection, $query);
$vax = mysqli_fetch_assoc($res);

$animals = mysqli_query($connection, "SELECT * FROM animals");
$vax_types = mysqli_query($connection, "SELECT * FROM vaccination_types");

if ($_POST) {
    $animal_id = (int)$_POST['animal_id'];
    $vtype_id = (int)$_POST['vtype_id'];
    $date = mysqli_real_escape_string($connection, $_POST['date']);
    $next_date = mysqli_real_escape_string($connection, $_POST['nextDate']);

    $sql = "UPDATE animal_vaccination SET 
            animal_id=$animal_id, 
            vtype_id=$vtype_id, 
            date='$date', 
            nextDate='$next_date' 
            WHERE av_id=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: animal_vacines.php");
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
    <title>Edit Vaccination Record | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Vaccination Record</h2>
            <p class="text-secondary small">Update vaccination details</p>
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
                                <option value="<?php echo $a['animal_id']; ?>" <?php echo $vax['animal_id'] == $a['animal_id'] ? 'selected' : ''; ?>>
                                    <?php echo $a['name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Vaccine Type</label>
                        <select name="vtype_id" class="form-select" required>
                            <?php while($vt = mysqli_fetch_assoc($vax_types)): ?>
                                <option value="<?php echo $vt['vtype_id']; ?>" <?php echo $vax['vtype_id'] == $vt['vtype_id'] ? 'selected' : ''; ?>>
                                    <?php echo $vt['vaccine_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Date Given</label>
                            <input type="date" name="date" class="form-control" value="<?php echo $vax['date']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Next Due Date</label>
                            <input type="date" name="nextDate" class="form-control" value="<?php echo $vax['nextDate']; ?>" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Vaccination</button>
                        <a href="animal_vacines.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
