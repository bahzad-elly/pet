<?php
include 'connect.php';
session_start();

//delete animals
if (!isset($_SESSION['name'])){
    header("location:index.php");
};

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM animals WHERE animal_id = $id";

    if (mysqli_query($connection, $sql)) {
        header("Location: animals.php"); 
    }
}


// delete intkates

if (isset($_GET['iid'])) {
    $iid = (int)$_GET['iid'];
    $sql2 = "DELETE FROM intake_source WHERE iid = $iid";

    if (mysqli_query($connection, $sql2)) {
        header("Location: intake.php"); 
    }
}

//delete vaccines
if (isset($_GET['vid'])) {
    $vid = (int)$_GET['vid'];
    $sql3 = "DELETE FROM vaccination_types WHERE vtype_id = $vid";

    if (mysqli_query($connection, $sql3)) {
        header("Location: vaccination_type.php"); 
    }
}

//delete users
if (isset($_GET['uid'])) {
    $uid = (int)$_GET['uid'];
    $sql4 = "DELETE FROM users WHERE uid = $uid";

    if (mysqli_query($connection, $sql4)) {
        header("Location: users.php"); 
    }
}

// delete adopters
if (isset($_GET['adp_id'])) {
    $adp_id = (int)$_GET['adp_id'];
    $sql5 = "DELETE FROM adopters WHERE adopterId = $adp_id";

    if (mysqli_query($connection, $sql5)) {
        header("Location: adopters.php"); 
    }
}

// delete adoptions
if (isset($_GET['adopt_id'])) {
    $adopt_id = (int)$_GET['adopt_id'];
    $sql6 = "DELETE FROM adoption WHERE adoption_id = $adopt_id";

    if (mysqli_query($connection, $sql6)) {
        header("Location: adoption.php"); 
    }
}

// delete medical records
if (isset($_GET['rec_id'])) {
    $rec_id = (int)$_GET['rec_id'];
    $sql7 = "DELETE FROM medical_record WHERE record_id = $rec_id";

    if (mysqli_query($connection, $sql7)) {
        header("Location: medical_record.php"); 
    }
}

?>