<!--Code for login system-->
<?php
$connection = mysqli_connect('washington.uww.edu', 'anglesjs29', 'ja7163');
if (!$connection){
    //die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'cs366-2217_anglesjs29');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>