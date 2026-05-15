<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])){
     header("Location: index.php");
}


if ($_POST) {
    $sname =$_POST['sname'];
    $stype =$_POST['stype'];
    $phone =$_POST['phone'];
    $address =$_POST['address'];

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intake Management | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php";?>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Intake Management</h2>
                <p class="text-secondary small">Manage organizations and individuals providing animals</p>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-plus-circle me-2"></i> Register New Source</h6>
            </div>
            <div class="card-body p-4">
                <form method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Source Name</label>
                        <input name="sname" class="form-control" placeholder="e.g. Happy Paws NGO" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Type</label>
                        <input name="stype" class="form-control" placeholder="e.g. NGO, Individual">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Phone</label>
                        <input name="phone" class="form-control" placeholder="Contact number">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Address</label>
                        <input name="address" class="form-control" placeholder="Location details">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Add Source</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Source Name</th>
                            <th>Type</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sources as $source): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light p-2 rounded-circle me-3 text-primary">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="fw-bold"><?php echo $source['sname']; ?></div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark fw-normal border"><?php echo $source['stype']; ?></span></td>
                            <td><i class="fas fa-phone-alt me-2 text-muted small"></i> <?php echo $source['phone']; ?></td>
                            <td><span class="text-muted small"><?php echo $source['address']; ?></span></td>
                            <td class="text-end">
                                <a href="edit_intake.php?id=<?php echo $source['iid']; ?>" class="btn btn-light btn-sm text-primary me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="deletes.php?iid=<?php echo $source['iid']; ?>" class="btn btn-light btn-sm text-danger shadow-sm" onclick="return confirm('Delete this source?')">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if($total == 0): ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">No intake sources found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>