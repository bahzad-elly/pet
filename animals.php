<?php
include 'connect.php';
session_start();

//check for security . 
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// boya left joinman danawa labar way hamu datakan bgarenetawa agar wargrishman nabe hich nishan nadat , wata null bgarenetawa
$result = mysqli_query($connection, "SELECT a.name,a.species,a.breed,a.age,a.status ,i.sname FROM animals a left join intake_source i on a.intake_id =i.iid; ");

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
            <h2>Animal Records</h2>
            <a href ="add_animals.php" class="bg-success text-white p-2 rounded-2">+ Add New Animal</a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Breed</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>intake source</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($array = mysqli_fetch_assoc($result)): ?>
                            <td><strong><?php echo $array['name']; ?></strong></td>
                            <td><?php echo $array['species']; ?></td>
                            <td><?php echo $array['breed']; ?></td>
                            <td><?php echo $array['age']; ?> yrs</td>
                            <td>
                                <span class="badge <?php 
                                    echo $array['status'] == 'Available' ? 'bg-info' : 
                                        ($array['status'] == 'Adopted' ? 'bg-success' : 'bg-warning'); 
                                ?>">
                                    <?php echo $array['status']; ?>
                                </span>
                            </td>
                            <td><?php echo $array['sname']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>