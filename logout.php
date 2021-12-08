<?php
session_start();
session_destroy();
header('Location: login.php');
echo '<script type="text/javascript">sessionStorage.removeItem("userId")</script>';
?>