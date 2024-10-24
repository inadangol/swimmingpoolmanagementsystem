<?php

include 'config.php';

session_start();

if(isset($_POST['submit'])){

   
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
  

   $select = " SELECT * FROM customers WHERE email ='$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

     

      if($row['user_type'] == 'user'){
         
         $_SESSION['id']= $row['id'];
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email']=$row['email'];
          $_SESSION['user_id']=$row['id'];

         //  $_SESSION['email']=$_POST['email'];



         header('location:Package.php');

      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css" />

    
</head>
<body class="login-page">
 <div class="form-container">
      <form action="" method="post">
        <h3>login now</h3>
        <?php
         if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
          
        <input type="email" name="email" required placeholder="enter your email">
        <input type="password" name="password" required placeholder="enter your password">
        <input type="submit" name="submit" value="login now" class="form-btn">
        <a href="trelogin.php" style="color:white;">Are you trainer?</a>
             <p>Don't have an account? <a href="Signin.php">Register Now</a></p>
    </form>

 </div>
    
</body>
</html>