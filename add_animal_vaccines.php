<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['name'])){
    header("Location: index.php");
}

$animals_res = mysqli_query($connection, "SELECT animal_id, name FROM animals");
$types_res = mysqli_query($connection, "SELECT vtype_id, vaccine_name FROM vaccination_types");

if ($_POST) {
    $aid = $_POST['animal_id'];
    $vid = $_POST['vtype_id'];
    $date = $_POST['date'];
    $nextdate = $_POST['nextdate'];
   $uid = $_SESSION['uid'] ?? null;

    $sql = "INSERT INTO animal_vaccination (animal_id, vtype_id, date, nextDate, userId) 
            VALUES ('$aid', '$vid', '$date', '$nextdate', " . ($uid ? "'$uid'" : "NULL") . ")";
    
    if (mysqli_query($connection, $sql)) {
        header("Location:animal_vacines.php");
    } else {
        echo "Error: " . mysqli_error($connection);
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
        .main-content { margin-left: 250px; padding: 30px; }
    </style>
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-header bg-primary text-white">New Vaccination Entry</div>
            <div class="card-body">
                <form method="POST">
                    <label class="small">Animal</label>
                    <select name="animal_id" class="form-select mb-2" required>
                        <?php while($a = mysqli_fetch_assoc($animals_res)): ?>
                            <option value="<?php echo $a['animal_id']; ?>"><?php echo $a['name']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="small">Vaccine Type</label>
                    <select name="vtype_id" class="form-select mb-2" required>
                        <?php while($v = mysqli_fetch_assoc($types_res)): ?>
                            <option value="<?php echo $v['vtype_id']; ?>"><?php echo $v['vaccine_name']; ?></option>
                        <?php endwhile; ?>
                    </select>

                    <label class="small">Vaccination Date</label>
                    <input type="date" name="date" class="form-control mb-2" required>

                    <label class="small">Next Due Date</label>
                    <input type="date" name="nextdate" class="form-control mb-3" required>

                    <button class="btn btn-success w-100">Save Record</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>