<?php
// this file for connect database to php code (backend)

$connection = mysqli_connect("localhost", "root", "", "pet_adoption_db");

if(!$connection){
    die("Connection failed: " . mysqli_connect_error()); }


?>