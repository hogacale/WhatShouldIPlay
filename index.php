

<?php 
require('login.php');
/*
session_start();
session_unset();
session_destroy();
include('pdo_connect.php');

if(isset($_SESSION['use']))   
{
    header("Location:index.html"); 
}

if(isset($_POST['login']))   
{
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    strtolower($user);
    $sql = "SELECT * FROM User WHERE username = '$user' AND password = '$pass';";
    $response = getAllRecords($sql, $db);
    if(count($response) > 0)    
    {                                   
        $_SESSION['use']=$user;
        echo '<script type="text/javascript"> window.open("index.html","_self");</script>';
    }
    else
    {  
        $error = "<h3>Invalid Username or Password.</h3>";  
    }
}
if(isset($_POST['register']))
{
    include('register.php');
}
*/
?>

