<?php
@include 'config.php';

$error = []; // Initialize an empty array for errors
if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    //check is user already exists
 
    $select = " SELECT * FROM customers WHERE email = '$email' && password = '$pass' ";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'User already exist!';
 
    }else{
 
       if($pass != $cpass){
          $error[] = 'Password does not match!';
       }else{
         //insert new user
          $insert = "INSERT INTO customers(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
          if(mysqli_query($conn, $insert)){
          header('location:Login.php');
          exit();
       }
       else{
         $error[] = 'Error: ' . mysqli_error($conn);
      
       }
    }
 
 }
}
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="login-page">
      <div class="form-container">

          <form action="" method="post">
            <h3>Register now</h3>
            <?php
                if(isset($error)){
                   foreach($error as $error){
                   echo '<span class="error-msg">'.$error.'</span>';
                 };
               };
             ?>
   
                <input type="text" name="name" required placeholder="enter your name">
                <input type="email" name="email" required placeholder="enter your email">
                <input type="password" name="password" required placeholder="enter your password">
                <input type="password" name="cpassword" required placeholder="confirm your password">
                    <select name="user_type">
                    <option value="user">user</option>
                    
                    </select>
               <input type="submit" name="submit" value="register now" class="form-btn">
               <p>Already have an account? <a href="Login.php">Login Now</a></p>
          </form>

      </div>
    
</body>
</html>