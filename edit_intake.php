<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM intake_source WHERE iid = $id";
$res = mysqli_query($connection, $query);
$source = mysqli_fetch_assoc($res);

if ($_POST) {
    $sname = mysqli_real_escape_string($connection, $_POST['sname']);
    $stype = mysqli_real_escape_string($connection, $_POST['stype']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    $sql = "UPDATE intake_source SET 
            sname='$sname', 
            stype='$stype', 
            phone='$phone', 
            address='$address' 
            WHERE iid=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: intake.php");
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
    <title>Edit Intake Source | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Intake Source</h2>
            <p class="text-secondary small">Update details for <span class="text-primary"><?php echo $source['sname']; ?></span></p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Source Name</label>
                        <input type="text" name="sname" class="form-control" value="<?php echo $source['sname']; ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Type</label>
                            <input type="text" name="stype" class="form-control" value="<?php echo $source['stype']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $source['phone']; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Address</label>
                        <textarea name="address" class="form-control" rows="3"><?php echo $source['address']; ?></textarea>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Source Details</button>
                        <a href="intake.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
