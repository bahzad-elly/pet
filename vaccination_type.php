<?php
include 'connect.php';
session_start();

//check for security . 
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

$result = mysqli_query($connection,"SELECT * From vaccination_types");
/*
CRUD 
create
read
update
delete

*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Animals</title>
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
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Vaccinations</h2>
            <a href ="add_vaccines.php" class="bg-success text-white p-2 rounded-2">+ Add New vaccine</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>vaccine Name</th>
                            <th>Description</th>
                            <th>F-month</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($array = mysqli_fetch_assoc($result)): ?>
                            <td><strong><?php echo $array['vaccine_name']; ?></strong></td>
                            <td><?php echo $array['description']; ?></td>
                            <td><?php echo $array['frequency_months']; ?> month</td>
                            <td>
                            <a href="delete_vaccine.php?id=<?php echo $array['vtype_id']; ?>" 
                                 class="btn btn-danger btn-sm" 
                                 onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>