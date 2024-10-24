<?php

@include 'config.php';

session_start();

$trainer_id = $_SESSION['trainer_id'];

if(!isset($trainer_id)){
   header('location: trelogin.php');
};

// Fetch trainer details along with the number of assigned trainees
$select_trainers = mysqli_query($conn, "
    SELECT 
        t.trainer_id, 
        t.trainer_name, 
        t.trainer_salary, 
        COUNT(trainee.c_id) as total_trainees
    FROM 
        trainers t
    LEFT JOIN 
        trainee ON t.trainer_id = trainee.trainer_id
    GROUP BY 
        t.trainer_id
") or die('Query failed: ' . mysqli_error($conn));
?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Total Salary</title>
</head>
<body>
     <!----------------------------- header ---------------------------->
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

<!-------------------------------------body----------------------------->
<div class="salary">
    <table class="table">
        <thead>
            <tr>
                <th>Payment</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($select_trainers) > 0) {
                while ($row = mysqli_fetch_assoc($select_trainers)) {
                    $salary = $row['trainer_salary'];
                    $total_trainees = $row['total_trainees'];
                    $commission_per_head = 0.05 * $salary;
                    $total_commission = $commission_per_head * $total_trainees;
                    $total_amount = $salary + $total_commission;
                    ?>
                    <tr>
                        <td>Monthly Salary</td>
                        <td><?php echo $salary; ?></td>
                        <td><?php echo $salary; ?></td>
                    </tr>
                    <tr>
                        <td>Per Student Commission</td>
                        <td><?php echo $commission_per_head; ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Total Commission</td>
                        <td><?php echo $total_commission; ?></td>
                        <td><?php echo $total_commission; ?></td>
                    </tr>
                    <tr>
                        <td>Total Amount</td>
                        <td></td>
                        <td><?php echo $total_amount; ?></td>
                    </tr>
                    <?php
                }
            } else {
                echo "<span>No Trainer Added</span>";
            }
            ?>
        </tbody>
    </table>
</div>



</body>
</html>