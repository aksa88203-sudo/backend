<?php
include 'config.php';
if(isset($_GET['action']) && $_GET['action']==='login' && $_SESSION['REQUESTED_METHOD']==='POST'){
  $name=$_POST['name']??'';
      $email=$_POST['email']??'';
      $password=$_POST['password']??'';
      $phone=$_POST['phone']??'';
      $address=$_POST['address']??'';
      }

    if(isset($_SESSION['registered_user']) && $_SESSION['registered_user']['name']===$name && $_SESSION['registered_user']['email']===$email && $_SESSION['registered_user']['password']===$password && $_SESSION['registered_user']['phone']===$phone && $_SESSION['registered_user']['address']===$address){
    $_SESSION['user']=['email' => $email];
    header("Location: dashboard.php");
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>
<body>
  <div>
  <h4>Login Form</h4>
    <label>Name:</label>
    <input type="text" id="name" placeholder="Enter your name."><br><br>
    <label>Email:</label>
    <input type="text" id="email" placeholder="Enter your email."><br><br>
    <label>Password:</label>
    <input type="password" id="password" placeholder="Enter the password."><br><br>
    <label>Phone:</label>
    <input type="phone" id="phone" placeholder="Enter your phone number."><br><br>
    <label>Address:</label>
    <input type="text" id="address" placeholder="Enter your address."><br><br>
    <button><a href="index.php">Login</a></button>
  </div>
</body>
</html>