<?php
$host="localhost";
$user="root";
$pass="";
$db="backend";
session_start();

$conn=mysqli_connect($host, $user, $pass, $db);
if(! $conn){
  die("Connection failed.");
}else{
  echo "OK!";
}
?>

