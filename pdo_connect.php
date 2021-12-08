<?php

$user = 'hoganct11';
$pass = 'ch7463'; // default password is a blank string
$db_info='mysql:host=washington.uww.edu;dbname=cs366-2217_hoganct11';
try {
    $db = new PDO($db_info, $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>