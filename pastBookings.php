<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
</head>
<body>
   <?php
   include 'header.php';
   ?>

<div class="container-body">
<div class="container">
   <?php
    session_start();
    include 'config.php';

     $c_email=$_SESSION['user_email'];

     if(isset($c_email)){ 
        $sql="SELECT * 
        FROM trainee AS t
        INNER JOIN trainers AS tr 
        ON t.trainer_id = tr.trainer_id 
        WHERE c_email = '$c_email'";
        

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
           // output data of each row
             while($row = mysqli_fetch_assoc($result)) {         
               echo '<div class="trainee-box">';
               echo '<p>Name: '.$row['c_name'].'</p>';
               echo '<p>Guardian Name: '.$row['c_guardian_name'].'</p>';
               echo '<p>Address: '.$row['c_address'].'</p>';
               echo '<p>DOB: '.$row['c_date_of_birth'].'</p>';
               echo '<p>Gender: '.$row['c_gender'].'</p>';
               echo '<p>Contact No.: '.$row['c_contact'].'</p>';
               echo '<p>Start Date: '.$row['c_start_date'].'</p>';
               echo '<p>End Date: '.$row['c_end_date'].'</p>';
               echo '<p>Time: '.$row['p_time'].'</p>';
               echo '<p>Trainer Name: '.$row['trainer_name'].'</p>';
               echo '</div>';
                }
        } else {
             echo "0 results";
         }
         
    }
    mysqli_close($conn);
     
?>
</div>
   </div>

</body>
</html>
