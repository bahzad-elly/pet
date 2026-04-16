<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])) header("Location: index.php");


if ($_POST) {
    $sname = mysqli_real_escape_string($connection, $_POST['sname']);
    $stype = mysqli_real_escape_string($connection, $_POST['stype']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    $sql = "INSERT INTO intake_source (sname, stype, phone, address) 
            VALUES ('$sname', '$stype', '$phone', '$address')";
    
    mysqli_query($connection, $sql);
    header("Location: intake.php"); // Refresh to show new data
}

// 2. Fetch existing sources for the table
$res = mysqli_query($connection, "SELECT * FROM intake_source");
$sources = mysqli_fetch_all($res, MYSQLI_ASSOC);
$total = count($sources);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
.sidebar { 
height: 100vh; 
width: 250px;
position: fixed;
padding-top: 20px; 
}
.sidebar a {
color: white;
text-decoration: none;
display: block;
padding: 15px; 
}
.sidebar a:hover { 
background:rgb(12, 194, 244);
}
.main-content {
margin-left: 250px;
padding: 30px; 
}
</style>
</head>
<body>
    <?php include "sidebar.php";?>

    <div class="main-content">
        <h2>Intake Management</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">Add Intake Source</div>
            <div class="card-body">
                <form method="POST" class="row g-2">
                    <div class="col-md-3">
                        <input name="sname" class="form-control" placeholder="Source Name" required>
                    </div>
                    <div class="col-md-2">
                        <input name="stype" class="form-control" placeholder="Type (e.g. NGO)">
                    </div>
                    <div class="col-md-2">
                        <input name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="col-md-3">
                        <input name="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success w-100">Add Source</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Source Name</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < $total; $i++): ?>
                    <tr>
                        <td><?php echo $sources[$i]['iid']; ?></td>
                        <td><strong><?php echo $sources[$i]['sname']; ?></strong></td>
                        <td><?php echo $sources[$i]['stype']; ?></td>
                        <td><?php echo $sources[$i]['phone']; ?></td>
                        <td><?php echo $sources[$i]['address']; ?></td>
                    </tr>
                    <?php endfor; ?>
                    <?php if($total == 0): ?>
                        <tr><td colspan="5" class="text-center">No intake sources found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>