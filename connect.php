<?php
// this file for connect database to php code (backend)

$local = "localhost";
$user = "root";
$pass = "";
$dbname = "pet_adoption_db";

$connection = mysqli_connect($local, $user, $pass, $dbname);

if(!$connection){
    die("ema errorman haya : ".mysqlie_connect_error());

}
?>