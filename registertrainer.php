<?php
session_start();
@include 'config.php'; // Include the database connection file

$error = []; // Initialize an empty array for errors

function addError($field, $message) {
  global $error;
  $error[$field] = $message;
}

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Rest of your code goes here


if(isset($_POST['submit'])){

    $trainer_name = mysqli_real_escape_string($conn, $_POST['trainer_name']);
    $trainer_email = mysqli_real_escape_string($conn, $_POST['trainer_email']);
    $trainer_contact = mysqli_real_escape_string($conn, $_POST['trainer_contact']);
    $trainer_address = mysqli_real_escape_string($conn, $_POST['trainer_address']);
    $trainer_gender = mysqli_real_escape_string($conn, $_POST['trainer_gender']);
    $trainer_salary = mysqli_real_escape_string($conn, $_POST['trainer_salary']);
    $trainer_username = mysqli_real_escape_string($conn, $_POST['trainer_username']);
    $trainer_pass = md5($_POST['trainer_password']);
    $trainer_cpass = md5($_POST['trainer_cpassword']);
    $user_type = $_POST['user_type'];

    // Validation for contact number
    if(strlen($trainer_contact) != 10 || !preg_match('/^9/', $trainer_contact)) {
      addError('trainer_contact', "Contact number should be 10 digits long and start with 9!");
     
     }

  // Validation for salary
  if ($trainer_salary >= 100000) {
    addError('trainer_salary', "Salary should be below $100,000!");
    }

 
 // Function to validate password
function validatePassword($password) {
  // Validate password length and if password contains at least one special character
  if (strlen($password) < 8 || !preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password) ) {
      return false;
  }
  return true;
}
// Check password validation before processing form submission
if (isset($_POST['submit']) && !validatePassword($_POST['trainer_password'])) {
  addError('trainer_password', "Password must be at least 8 characters long and contain at least one special character!");
}


    //check is user already exists
 
    $select = " SELECT * FROM trainers WHERE trainer_email = '$trainer_email' && trainer_password = '$trainer_pass' ";
    $result = mysqli_query($conn, $select);
          if(mysqli_num_rows($result) > 0){
 
       $error[] = 'Trainer already exist!';
 
    }else{
 
       if($trainer_pass != $trainer_cpass){
          $error[] = 'Password does not match!';
       }
       else{
         //insert new user
          $insert = "INSERT INTO trainers(trainer_name, trainer_email, trainer_contact, trainer_address, trainer_gender, trainer_salary, trainer_username, trainer_password, user_type) VALUES(' $trainer_name','$trainer_email','$trainer_contact','$trainer_address','$trainer_gender','$trainer_salary','$trainer_username','$trainer_pass','$user_type')";
          if(mysqli_query($conn, $insert)){
          header('location:registertrainer.php');
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
    <link rel="stylesheet" href="styleadmin.css" />
    <title>Trainer registration by Admin</title>
</head>
<body>
     <!-- ........side menu...... -->
     <div class="side-menu">
        <div class="logo">
           <a href="dashboard.php">
			  <img src="images\logo2.png" alt="logo2" />
		   </a>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fa-regular fa-table-columns"></i>&nbsp; Dashboard</a></li>
            <li><a href="totalstudent.php"><i class="fa-solid fa-person-swimming"></i>&nbsp; Students</a></li>
            <li><a href="registertrainer.php"><i class="fa-solid fa-person"></i>&nbsp; Trainer</a></li>
            <li><a href="addpackages.php"><i class="fa-solid fa-box-archive"></i>&nbsp; Packages</a></li>
        </ul>
    </div> 



<!-- form part -->

<div class="form-trainer">

<form action="" method="post">
  <h3>Register New Trainer</h3>
      <div class="trainer-detail">
      <span>Trainer's Name:</span>
      <input type="text" name="trainer_name" required placeholder="enter your name">
      </div>

      <div class="trainer-detail">
      <span>Email:</span>
      <input type="email" name="trainer_email" required placeholder="enter your email">
      </div>

      <div class="trainer-detail">
        <span>Contact Number:</span>
      <input type="tel" name="trainer_contact" required pattern="[0-9]{10}" required placeholder="enter your contact">
           <?php
            if (!empty($error) && in_array("Contact number should be 10 digits long and start with 9!", $error)) {
            echo "<div style='color:red; font-size:13px; text-align:center; font-family:serif;'> Contact number should be 10 digits long and start with 9! </div>";
            }
            ?>
      </div>

      <div class="trainer-detail">
        <span>Address:</span>
      <input type="text" name="trainer_address" required placeholder="enter your adderss">
      </div>

      <div class="trainer-detail">
        <span>Gender:</span>
      <input type="radio" name="trainer_gender" value="male">Male
      <input type="radio" name="trainer_gender" value="female">Female
      <input type="radio" name="trainer_gender" value="Other">Other
      </div>

      <div class="trainer-detail">
        <span>Total Salary:</span>
        <input type="number" name="trainer_salary" required placeholder="enter salary">
        <?php if (!empty($error['trainer_salary'])): ?>
                <div style="color:red; font-size:13px; text-align:center; font-family:serif;">
                <?php echo $error['trainer_salary']; ?>
                </div>
            <?php endif; ?>
      </div>

      <div class="trainer-detail">
        <span>Trainer's Username:</span>
        <input type="text" name="trainer_username" required placeholder="enter username">
      </div>


      <div class="trainer-detail">
        <span>Enter Password:</span>
      <input type="password" name="trainer_password" required placeholder="enter your password">
      </div>

      <div class="trainer-detail">
        <span>Confirm Password:</span>
      <input type="password" name="trainer_cpassword" required placeholder="confirm your password">
      
      <?php if (!empty($error['trainer_password'])): ?>
                    <div style="color:red; font-size:13px; text-align:center; font-family:serif;">
                        <?php echo $error['trainer_password']; ?>
                    </div>
                <?php endif; ?>
      </div>
      <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div style="color:green; font-size:13px; text-align:center; font-family:serif;">
                Trainer registered successfully!
            </div>
      <?php endif; ?>
       
      <div class="trainer-detail">
        <select name="user_type">
        <option value="trainer">trainer</option>
        </select>
      </div>
      
       
     <input type="submit" name="submit" value="Register Now" class="form-btn">
     
</form>

</div>

    
</body>
</html>