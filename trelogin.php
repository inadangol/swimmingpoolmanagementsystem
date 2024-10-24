<?php

include 'config.php';

session_start();

if(isset($_POST['submit'])){

   
   $trainer_email = mysqli_real_escape_string($conn, $_POST['trainer_email']);
   $trainer_pass = md5($_POST['trainer_password']);
  

   $select = " SELECT * FROM trainers WHERE trainer_email ='$trainer_email' && trainer_password = '$trainer_pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'trainer'){

         $_SESSION['trainer_name'] = $row['trainer_name'];
         $_SESSION['trainer_email']=$row['trainer_email'];
         $_SESSION['trainer_id']=$row['trainer_id'];
         header('location:trainer_dashboard.php');



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
        <h3>Trainer login</h3>
        <?php
         if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
          
        <input type="email" name="trainer_email" required placeholder="enter your email">
        <input type="password" name="trainer_password" required placeholder="enter your password">
        <input type="submit" name="submit" value="login now" class="form-btn">
        <a href="Alogin.php" style="color:white;">Are you Admin?</a>
             
    </form>

 </div>
    
</body>
</html>