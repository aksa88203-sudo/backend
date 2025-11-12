<?php
include 'config.php';
if(session_status() === PHP_SESSION_ACTIVE){
  session_unset();
  session_destroy();
}
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//---SIGNUP---
if(isset($_GET['action']) && $_GET['action']==='signup' && $_SESSION['REQUESTED_METHOD']==='POST'){

  try{
    if(($_SESSION['REQUESTED_METHOD']) ==='POST'){
      $name=$_POST['name']??'';
      $email=$_POST['email']??'';
      $password=$_POST['password']??'';
      $phone=$_POST['phone']??'';
      $address=$_POST['address']??'';
      } else{
      $error="Invalid data.";
    }

      $sql="INSERT INTO order(name, email, password, phone, address) VALUES('".$name."','".$email."','".$password."', '".$phone."', '".$address."')";
      $stmt=$conn->prepare($sql);

      if($stmt->execute()){
        echo "<p>Signup successfully!</p>";
      } else{
        echo "<p>Error: ".$stmt->error."</p>";
      }
  } catch(Exception $e){
    throw $e;
  }
}
//---LOGIN---
if(isset($_GET['action']) && $_GET['action']==='login' && $_SESSION['REQUESTED_METHOD']==='POST'){
  $name=$_POST['name']??'';
      $email=$_POST['email']??'';
      $password=$_POST['password']??'';
      $phone=$_POST['phone']??'';
      $address=$_POST['address']??'';
      }

    if(isset($_SESSION['signup_user']) && $_SESSION['signup_user']['name']===$name && $_SESSION['signup_user']['email']===$email && $_SESSION['signup_user']['password']===$password && $_SESSION['signup_user']['phone']===$phone && $_SESSION['signup_user']['address']===$address){
    $_SESSION['user']=['email' => $email];
    header("Location: login.php");
    exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Page</title>
  <style>
    *{
      margin: 0;
      padding: 0;
    }
    body{
      width:100%;
      height:100%;
      background-color:lightgrey;
    }
    .form{
      width:400px;
      height:360px;
      background-color:bisque;
      letter-spacing:1px;
      border-radius:30px;
      margin-top:60px;
      margin-left:400px;
    }
    h4{
      margin-left:60px;
      font: bold;
      font-size:30px;
      align-items:center;
    }
    label{
      font:bold;
      font-size:20px;
      margin-left: 8px;
      margin-top: 10px;
    }
    input{
      width:240px;
      height:20px;
      border-radius:5px;
      margin-top: 10px;
    }
    button{
      width:160px;
      height:40px;
      border-radius: 20px;
      margin-left: 110px;
      margin-top:30px;
    }
    .log{
      margin-left:60px;
      font: bold;
      font-size:30px;
      margin-bottom:30px;
    }
  </style>
</head>
<body>
  <h2>Let's order</h2>
  <div class="form">
    <div class="log">
  <h4 id="signUp"><a href="index.php">Signup</a></h4>
  <h4 id="logIn" ><a href="login.php">Login</a></h4>
    </div>
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
    <button><a href="login.php">Submit order!</a></button>
  </div>
  <script>
    signUp=document.getElementById(signUp);
    logIn=document.getElementById(logIn);

    signUp.onclick(){
      signUp.style.display="block";
      logIn.style.display="none";
    }
    logIn.onclick(){
      signUp.style.display="none";
      logIn.style.display="block";
    }
  </script>
</body>
</html>