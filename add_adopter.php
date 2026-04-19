<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

if ($_POST) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $preference = $_POST['preference'];

    $sql = "INSERT INTO adopters (fname, lname, DoB, phone, address, preference) 
            VALUES ('$fname', '$lname', '$dob', '$phone', '$address', '$preference')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: adopters.php");
        exit();
    } else {
        $error = "Error adding adopter: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Adopter</title>
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
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-header bg-primary text-white">Add New Adopter</div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="row mb-2">
                        <div class="col">
                            <label class="small text-muted">First Name</label>
                            <input name="fname" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col">
                            <label class="small text-muted">Last Name</label>
                            <input name="lname" class="form-control" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="small text-muted">Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label class="small text-muted">Phone Number</label>
                        <input name="phone" class="form-control" placeholder="Phone Number">
                    </div>
                    <div class="mb-2">
                        <label class="small text-muted">Address</label>
                        <textarea name="address" class="form-control" placeholder="Address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted">Pet Preference (e.g., Dog, Cat, Young)</label>
                        <input name="preference" class="form-control" placeholder="Preference">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Save Adopter</button>
                        <a href="adopters.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
