<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location: Alogin.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Dashboard</title>
</head>
<body>
<?php
   if(isset($message)){
    foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
 }
?>
    <!-- .............................side menu......................... -->
    <div class="side-menu">
        <div class="logo">
           <a href="dashboard.php">
			  <img src="images\logo2.png" alt="logo2" />
		   </a>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fa-regular fa-table-columns"></i>&nbsp; Dashboard</a></li>
            <li><a href="studentapayment.php"><i class="fa-solid fa-person-swimming"></i>&nbsp; Students</a></li>
            <li><a href="registertrainer.php"><i class="fa-solid fa-person"></i>&nbsp; Trainer</a></li>
            <li><a href="addpackages.php"><i class="fa-solid fa-box-archive"></i>&nbsp; Packages</a></li>
        </ul>
    </div> 

    <!-- ..................................header board........................... -->
    <div class="container">
    <div class="header">
        <div class="nav">
            <h1>Welcome to Admin Dashboard</h1>
            <a href="admin_register.php" class="btn">Add New</a>
            <div class="user">
                <div class="img-admin">
                    <img src="images/profile.jpg" alt="">
                </div>
                <div class="account-box">
                    <p>username : <span><?php echo $_SESSION['admin_name']; ?></span></p>
                    <p>email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
                    <a href="logout.php" class="delete-btn">logout</a>
                    <div><a href="Alogin.php">New login</a></div>
                </div>
            </div>
        </div>
    </div>


<!-- .....................................links.................................... -->

       <div class="button">
           <a href="totalstudent.php" class="btn btn-info" role="button">Total Student</a>
           <a href="totalpackages.php" class="btn btn-info" role="button">Total Packages</a>
           <a href="totaltrainer.php" class="btn btn-info" role="button">Total Trainer</a>
    </div>
</div>









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
