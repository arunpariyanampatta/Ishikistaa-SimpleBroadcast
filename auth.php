<?php
session_start();
$username = $_GET["username"];
$password = $_GET["password"];

$con = mysqli_connect("localhost","dashboard_user","Ku2ZbNHdcALZfz2P@","tigo_sms_broadcast");

// Check connection
if ($con->connect_error){
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
	$password = md5($password);
  $sql = "SELECT * FROM login WHERE USER_NAME ='$username' AND PASSWORD = '$password'";

  $result = mysqli_query($con, $sql);

         if (mysqli_num_rows($result) > 0) {
          $_SESSION['loginuser'] = $username;
          $row = mysqli_fetch_assoc($result);
          $_SESSION['fullname'] = $row['first_name']." ".$row['last_name'];
             header("Location: home.php");
             exit();
         }else{
             header("Location: index.php?login_error=1");
             exit();
         }
