<!--Code for login system-->
<?php
$connection = mysqli_connect('washington.uww.edu', 'hoganct11', 'ch7463');
if (!$connection){
    //die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'cs366-2217_hoganct11');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>