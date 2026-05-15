<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM vaccination_types WHERE vtype_id = $id";
$res = mysqli_query($connection, $query);
$vaccine = mysqli_fetch_assoc($res);

if ($_POST) {
    $vaccine_name = mysqli_real_escape_string($connection, $_POST['vaccine_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $frequency = (int)$_POST['frequency_months'];

    $sql = "UPDATE vaccination_types SET 
            vaccine_name='$vaccine_name', 
            description='$description', 
            frequency_months=$frequency 
            WHERE vtype_id=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: vaccination_type.php");
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
    <title>Edit Vaccine Type | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Vaccine Type</h2>
            <p class="text-secondary small">Update details for <span class="text-primary"><?php echo $vaccine['vaccine_name']; ?></span></p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Vaccine Name</label>
                        <input type="text" name="vaccine_name" class="form-control" value="<?php echo $vaccine['vaccine_name']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo $vaccine['description']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Frequency (Months)</label>
                        <input type="number" name="frequency_months" class="form-control" value="<?php echo $vaccine['frequency_months']; ?>" required>
                        <div class="form-text">How often this vaccine should be administered.</div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Vaccine Type</button>
                        <a href="vaccination_type.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
