<?php

include 'config.php';

session_start();

if(isset($_POST['submit'])){

   
   $email = mysqli_real_escape_string($conn, $_POST['admin_email']);
   $pass = md5($_POST['admin_password']);
  

   $select = " SELECT * FROM admins WHERE admin_email ='$email' && admin_password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_types'] == 'admin'){

         $_SESSION['admin_name'] = $row['admin_name'];
         $_SESSION['admin_email']=$row['admin_email'];
         $_SESSION['admin_id']=$row['admin_id'];
         header('location:dashboard.php');



      }
     
   }else{
      $error[] = 'Incorrect email or password!';
   }

}

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
        <h3>Admin login</h3>
        <?php
         if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
          
        <input type="email" name="admin_email" required placeholder="enter your email">
        <input type="password" name="admin_password" required placeholder="enter your password">
        <input type="submit" name="submit" value="login now" class="form-btn">
        <a href="trelogin.php" style="color:white;">Are you trainer?</a>
             
    </form>

 </div>
    
</body>
</html>