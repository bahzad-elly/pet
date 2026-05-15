<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$id = (int)$_GET['id'];
$query = "SELECT * FROM adopters WHERE adopterId = $id";
$res = mysqli_query($connection, $query);
$adopter = mysqli_fetch_assoc($res);

if ($_POST) {
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $dob = mysqli_real_escape_string($connection, $_POST['dob']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $preference = mysqli_real_escape_string($connection, $_POST['preference']);

    $sql = "UPDATE adopters SET 
            fname='$fname', 
            lname='$lname', 
            DoB='$dob', 
            phone='$phone', 
            address='$address', 
            preference='$preference' 
            WHERE adopterId=$id";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: adopters.php");
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
    <title>Edit Adopter | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit Adopter</h2>
            <p class="text-secondary small">Update record for <span class="text-primary"><?php echo $adopter['fname'] . ' ' . $adopter['lname']; ?></span></p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">First Name</label>
                            <input type="text" name="fname" class="form-control" value="<?php echo $adopter['fname']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Last Name</label>
                            <input type="text" name="lname" class="form-control" value="<?php echo $adopter['lname']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?php echo $adopter['DoB']; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $adopter['phone']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Address</label>
                        <textarea name="address" class="form-control" rows="2"><?php echo $adopter['address']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Pet Preference</label>
                        <input type="text" name="preference" class="form-control" value="<?php echo $adopter['preference']; ?>" placeholder="e.g. Small dogs, Senior cats">
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Adopter Record</button>
                        <a href="adopters.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
