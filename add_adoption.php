<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$animals_query = mysqli_query($connection, "SELECT animal_id, name FROM animals WHERE status = 'Available'");
$adopters_query = mysqli_query($connection, "SELECT adopterId, fname, lname FROM adopters");

if ($_POST) {
    $animal_id = $_POST['animal_id'];
    $adopter_id = $_POST['adopter_id'];
    $adoption_date = $_POST['adoption_date'];
    $user_id = $_SESSION['uid'];

    mysqli_begin_transaction($connection);

    try {
    
        $sql_insert = "INSERT INTO adoption (adopter_id, animal_id, adoptiondate, user_id) 
                       VALUES ('$adopter_id', '$animal_id', '$adoption_date', '$user_id')";
        mysqli_query($connection, $sql_insert);

   
        $sql_update = "UPDATE animals SET status = 'Adopted' WHERE animal_id = '$animal_id'";
        mysqli_query($connection, $sql_update);

        mysqli_commit($connection);
        header("Location: adoption.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($connection);
        $error = "Error recording adoption: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Record Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; padding-top: 20px; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px; }
        .sidebar a:hover { background:rgb(12, 194, 244); }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">Record New Adoption</div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <label class="small text-muted">Select Animal (Available Only)</label>
                    <select name="animal_id" class="form-select mb-3" required>
                        <option value="">-- Choose Animal --</option>
                        <?php while($row = mysqli_fetch_assoc($animals_query)): ?>
                            <option value="<?php echo $row['animal_id']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label class="small text-muted">Select Adopter</label>
                    <select name="adopter_id" class="form-select mb-3" required>
                        <option value="">-- Choose Adopter --</option>
                        <?php while($row = mysqli_fetch_assoc($adopters_query)): ?>
                            <option value="<?php echo $row['adopterId']; ?>">
                                <?php echo $row['fname'] . ' ' . $row['lname']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label class="small text-muted">Adoption Date</label>
                    <input type="date" name="adoption_date" class="form-control mb-4" value="<?php echo date('Y-m-d'); ?>" required>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Confirm Adoption</button>
                        <a href="adoption.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
