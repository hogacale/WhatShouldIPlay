<?php  //Start the Session
session_start();
 require('pdo_connect.php');
//3. If the form is submitted or not.
//3.1 If the form is submitted
if (isset($_POST['username']) and isset($_POST['password']) and isset($_POST['age'])){
//3.1.1 Assigning posted values to variables.
$errors = array();

$username = $_POST['username'];
$password = $_POST['password'];
$age = $_POST['age'];


$user_check_query = "SELECT COUNT(userId) FROM User;";
$result = mysqli_query($connection, $user_check_query) or die(mysqli_error($connection));
$result = $result->fetch_array();
$quantity = intval($result[0]);
$userId = $quantity + 1;

//3.1.2 Checking the values are existing in the database or not
  // first check the database to make sure 
  // a user does not already exist with the same username
  $user_check_query = "SELECT * FROM User WHERE username='$username' OR userId=$userId LIMIT 1;";
  $result = mysqli_query($connection, $user_check_query) or die(mysqli_error($connection));
  $count = mysqli_num_rows($result);
  //$result = mysqli_query($connection, $user_check_query);
  //$user = mysqli_fetch_assoc($result);
  //echo '<script type="text/javascript"> console.log('.$user.');</script>';
  
  if ($count == 1) { // if user exists
    $fmsg = "Username already exists.";
    // if ($user['username'] === $username) {
    //   array_push($errors, "Username already exists");
    //   $fmsg = "Username already exists.";
  }
    else{
      $query = "INSERT INTO User VALUES ($userId, $age, '$username', '$password');";
  	mysqli_query($connection, $query);
  	$_SESSION['username'] = $username;
    $username = $_SESSION['username'];
    echo '<script type="text/javascript"> window.open("index.html","_self");</script>';
    }
  }
  // Finally, register user if there are no errors in the form
  /*
  if (count($errors) == 0) {
  	$query = "INSERT INTO User VALUES (0, $age, '$username', '$password');";
  	mysqli_query($connection, $query);
  	$_SESSION['username'] = $username;
    echo '<script type="text/javascript"> window.open("index.html","_self");</script>';
  }
  */

//}



?>

<html>
<head>
	<title>Register</title>
	
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<link rel="stylesheet" href="style.css" >

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
      <form class="form-signin" method="POST">
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
        <h2 class="form-signin-heading">Register New Account</h2>
	  <input type="text" name="username" class="form-control" placeholder="Username" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <input type="text" name="age" class="form-control" placeholder="Age" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.php">Back to Login</a>
      </form>
</div>

</body>

</html>

<script>
  sessionStorage.setItem('userId', $userId);
  let userId = sessionStorage.getItem('userId');
  sessionStorage.setItem('userName', $userId);
</script>
