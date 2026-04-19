<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$animals_query = mysqli_query($connection, "SELECT animal_id, name FROM animals");

if ($_POST) {
    $animal_id = $_POST['animal_id'];
    $treatment = $_POST['treatment'];
    $diagnoses = $_POST['diagnoses'];
    $treatedBy = $_POST['treatedBy'];
    $visit_type = $_POST['visit_type'];

    $sql = "INSERT INTO medical_record (animal_id, treatment, diagnoses, treatedBy, visit_type) 
            VALUES ('$animal_id', '$treatment', '$diagnoses', '$treatedBy', '$visit_type')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: medical_record.php");
        exit();
    } else {
        $error = "Error adding record: " . mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Medical Record</title>
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
            <div class="card-header bg-primary text-white">Add Medical Record</div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <label class="small text-muted">Select Animal</label>
                    <select name="animal_id" class="form-select mb-3" required>
                        <option value="">-- Choose Animal --</option>
                        <?php while($row = mysqli_fetch_assoc($animals_query)): ?>
                            <option value="<?php echo $row['animal_id']; ?>">
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <div class="mb-3">
                        <label class="small text-muted">Visit Type</label>
                        <select name="visit_type" class="form-select">
                            <option>Checkup</option>
                            <option>Emergency</option>
                            <option>Follow-up</option>
                            <option>Surgery</option>
                            <option>Vaccination</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted">Diagnosis</label>
                        <textarea name="diagnoses" class="form-control" placeholder="What was diagnosed?"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted">Treatment</label>
                        <textarea name="treatment" class="form-control" placeholder="What treatment was given?"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted">Treated By (Doctor/Staff Name)</label>
                        <input name="treatedBy" class="form-control" placeholder="Name of person who treated" value="<?php echo $_SESSION['name']; ?>">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Save Medical Record</button>
                        <a href="medical_record.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
