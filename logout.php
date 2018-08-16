<?php
session_start();
unset($_SESSION["loginuser"]);
header("Location: index.php");
exit();
