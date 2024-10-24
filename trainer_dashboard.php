<?php

@include 'config.php';

session_start();

$trainer_id = $_SESSION['trainer_id'];

if(!isset($trainer_id)){
   header('location: trelogin.php');
};

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Trainer Dashboard</title>
</head>
<body>
    <!--------------------------------header---------------------------->
<div class="headertrainer">
            
    
               <label class="logoo">
                <a href="trainer_dashboard.php">
		            <img src="images\logo2.png" alt="logo2" />
	            </a>
                </label>
                <div class="user">
                    <div class="img-admin">
                    <img src="images/profile.jpg" alt="">
                    </div>
                     <div class="account-box">
                    <p>Username : <span><?php echo $_SESSION['trainer_name']; ?></span></p>
                    <p>Email : <span><?php echo $_SESSION['trainer_email']; ?></span></p>
                    <a href="logout.php" class="delete-btn">logout</a>
                    <div><a href="trelogin.php">New login</a></div>
                    </div>
                </div>
    

</div>

<!----------------------------body part------------------------------------>
<div class="trainer-body">
    <h1> Welcome to Trainer Dashboard</h1>
    <div class="t-button">
        <a href="trainertotalstudent.php" class="t-btn" role="button">Total Student</a>
        <a href="trainertotalsalary.php" class="t-btn" role="button">Total Salary</a>
    </div>
    
</div>



















<!----------------------------------------script---------------------------------------------->
<script>
 document.addEventListener('DOMContentLoaded', function () {
    var imgAdmin = document.querySelector('.img-admin');
    var accountBox = document.querySelector('.account-box');

    imgAdmin.addEventListener('click', function () {
        accountBox.style.display = (accountBox.style.display === 'block') ? 'none' : 'block';
    });
    });

</script>
    
</body>
</html>