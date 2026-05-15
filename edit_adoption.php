<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM adoption WHERE adoption_id = $id";
$res = mysqli_query($connection, $query);
$adoption = mysqli_fetch_assoc($res);

$animals = mysqli_query($connection, "SELECT * FROM animals WHERE status = 'Available' OR animal_id = " . $adoption['animal_id']);
$adopters = mysqli_query($connection, "SELECT * FROM adopters");

if ($_POST) {
    $animal_id = (int)$_POST['animal_id'];
    $adopter_id = (int)$_POST['adopter_id'];
    $adoption_date = mysqli_real_escape_string($connection, $_POST['adoption_date']);

    // If animal changed, update old animal to Available and new animal to Adopted
    if ($animal_id != $adoption['animal_id']) {
        mysqli_query($connection, "UPDATE animals SET status='Available' WHERE animal_id=" . $adoption['animal_id']);
        mysqli_query($connection, "UPDATE animals SET status='Adopted' WHERE animal_id=$animal_id");
    }

    $sql = "UPDATE adoption SET 
            animal_id=$animal_id, 
            adopter_id=$adopter_id, 
            adoptiondate='$adoption_date' 
            WHERE adoption_id=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: adoption.php");
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
    <title>Edit Adoption | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Adoption Record</h2>
            <p class="text-secondary small">Update adoption details</p>
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
                                <option value="<?php echo $a['animal_id']; ?>" <?php echo $adoption['animal_id'] == $a['animal_id'] ? 'selected' : ''; ?>>
                                    <?php echo $a['name']; ?> (<?php echo $a['species']; ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Adopter</label>
                        <select name="adopter_id" class="form-select" required>
                            <?php while($adp = mysqli_fetch_assoc($adopters)): ?>
                                <option value="<?php echo $adp['adopterId']; ?>" <?php echo $adoption['adopter_id'] == $adp['adopterId'] ? 'selected' : ''; ?>>
                                    <?php echo $adp['fname'] . ' ' . $adp['lname']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Adoption Date</label>
                        <input type="date" name="adoption_date" class="form-control" value="<?php echo $adoption['adoptiondate']; ?>" required>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Record</button>
                        <a href="adoption.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
