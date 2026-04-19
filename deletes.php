<?php
include 'connect.php';
session_start();

//delete animals
if (!isset($_SESSION['name'])){
    header("location:index.php");
};

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM animals WHERE animal_id = $id";

    if (mysqli_query($connection, $sql)) {
        header("Location: animals.php"); 
    }
}


// delete intkates

if (isset($_GET['iid'])) {
    $iid = $_GET['iid'];
    $sql2 = "DELETE FROM intake_source WHERE iid = $iid";

    if (mysqli_query($connection, $sql2)) {
        header("Location: intake.php"); 
    }
}

//delete vaccines

?>