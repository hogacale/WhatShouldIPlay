<?php

$user = 'anglesjs29';
$pass = 'ja7163'; // default password is a blank string
$db_info='mysql:host=washington.uww.edu;dbname=cs366-2217_anglesjs29';
try {
    $db = new PDO($db_info, $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>

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