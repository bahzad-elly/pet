<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])){
     header("Location: index.php");
     exit();
}


$sources_query = mysqli_query($connection, "SELECT iid, sname FROM intake_source");

if ($_POST) {
    $name = $_POST['name'];
    $species = $_POST['species'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $status = $_POST['status'];
    $intake_id = $_POST['intake_id'];


    $sql = "INSERT INTO animals (name, species, breed, age, status, intake_id) 
            VALUES ('$name', '$species', '$breed', '$age', '$status', '$intake_id')";
    
    if (mysqli_query($connection, $sql)) {
        header("Location: animals.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar { height: 100vh; width: 250px; position: fixed; padding-top: 20px; background: #212529; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 15px; }
        .sidebar a:hover { background:rgb(12, 194, 244); }
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>

    <div class="main-content">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">Add Animal & Select Intake</div>
            <div class="card-body">
                <form method="POST">
                    <input name="name" class="form-control mb-2" placeholder="Name" required>
                    <input name="species" class="form-control mb-2" placeholder="Species" required>
                    <input name="breed" class="form-control mb-2" placeholder="Breed">
                    <input type="number" name="age" class="form-control mb-2" placeholder="Age">
                    
                    <label class="small text-muted">Intake Source</label>
                    <select name="intake_id" class="form-select mb-2" required>
                        <option value="">-- Choose Source --</option>
                        <?php while($row = mysqli_fetch_assoc($sources_query)): ?>
                            <option value="<?php echo $row['iid']; ?>">
                                <?php echo $row['sname']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label class="small text-muted">Select Status</label>
                    <select name="status" class="form-select mb-3">
                        <option>Available</option>
                        <option>Adopted</option>
                    </select>

                    <button type="submit" class="btn btn-success w-100">Save Animal</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>