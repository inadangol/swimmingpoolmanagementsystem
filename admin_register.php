<?php
@include 'config.php';

$error = []; // Initialize an empty array for errors

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $pass = md5($_POST['admin_password']);
    $cpass = md5($_POST['admin_cpassword']);
    $user_type = $_POST['user_types'];

    //check is user already exists
 
    $select = " SELECT * FROM admins WHERE admin_email = '$email' && admin_password = '$pass' ";
 
    $result = mysqli_query($conn, $select);
 
    if(mysqli_num_rows($result) > 0){
 
       $error[] = 'User already exist!';
 
    }else{
 
       if($pass != $cpass){
          $error[] = 'Password does not match!';
       }
       else{
         //insert new user
          $insert = "INSERT INTO admins(admin_name, admin_email, admin_password, user_types) VALUES('$name','$email','$pass','$user_type')";
          if(mysqli_query($conn, $insert)){
          header('location:dashboard.php');
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
<body>
       <!----------------------------------------- side menu------------------------------------- -->
<?php
include 'adminheader.php';
?>




      <div class="form-container">

          <form action="" method="post">
            <h3>Register New Admin</h3>
            <?php
                if(isset($error)){
                   foreach($error as $error){
                   echo '<span class="error-msg">'.$error.'</span>';
                 };
               };
             ?>
   
                <input type="text" name="admin_name" required placeholder="enter your name">
                <input type="email" name="admin_email" required placeholder="enter your email">
                <input type="password" name="admin_password" required placeholder="enter your password">
                <input type="password" name="admin_cpassword" required placeholder="confirm your password">
                    <select name="user_types">
                    <option value="admin">admin</option>
                    
                    </select>
               <input type="submit" name="submit" value="register now" class="form-btn">
               <p>Already have an account? <a href="admin_login.php">Login Now</a></p>
          </form>

      </div>
    
</body>
</html>