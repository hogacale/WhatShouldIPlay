<?php 
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
 ?>


<!DOCTYPE html>    
<html>    
<head>    
    <title>Login</title>    
    <link rel="stylesheet" type="text/css" href="style.css">    
</head>    
<body>    
    <h1>Login Page</h1><br>    
<div class="login">    
    <form id="login" method="post" action="">    
        <label><b>User Name</b></label>    
        <input type="text" name="user" id="user" placeholder="Username">    
        <br><br>    
        <label><b>Password</b></label>    
        <input type="Password" name="pass" id="pass" placeholder="Password">    
        <br><br>    
        <input type="submit" name="login" id="log" value="Login">       
        <br><br>
    </form>   
    <?php 
    if (isset($error)){
        echo $error;
    }
    ?> 
</div>    
</body>    
</html>     

<?php
function getAllRecords($sql, $db){
   // prepare SQL statement
   $stm = $db->prepare($sql);
   // execute SQL statement
   $stm->execute();
   // fetch all records
   $response = $stm->fetchAll(PDO::FETCH_ASSOC);
return $response;
}
?>


