<?php
@include 'config.php';
session_start();

$trainer_id = $_SESSION['trainer_id'];
if(!isset($trainer_id)){
   header('location: trelogin.php');
};

$message = "";



//    to delete trainer
    if(isset($_GET['delete'])){
      $delete_id = mysqli_real_escape_string($conn, $_GET['delete']); 
      $sql =  "DELETE FROM trainee WHERE c_id = $delete_id ";
      $delete_query = mysqli_query($conn, $sql);
    if($delete_query){

        $message = "Trainee has been removed.";
    } else {
        $message = "Trainee could not be removed. Error: " . mysqli_error($conn);
 
    }
}

if(isset($_POST['update_trainee'])){
    $update_c_id = $_POST['update_c_id'];
    $update_c_name = $_POST['update_c_name'];
    $update_g_name = $_POST['update_g_name'];
    $update_dob = $_POST['update_dob'];
    $update_c_email = $_POST['update_c_email'];
    $update_c_address = $_POST['update_c_address'];
    $update_c_gender = $_POST['update_c_gender'];
    $update_c_contact = $_POST['update_c_contact'];
    $update_c_start_date = $_POST['update_c_start_date'];
    $update_c_end_date = $_POST['update_c_end_date'];
    $update_p_time = $_POST['update_p_time'];
    $update_p_total_day = $_POST['update_p_total_day'];
    $update_p_total_price = $_POST['update_p_total_price'];
   
    //validation part
     $errors = [];
    
     if (strlen($update_c_contact) != 10 || !preg_match('/^[9][0-9]{9}$/', $update_c_contact)) {
        $errors['update_c_contact'] = "Contact number should be 10 digits long and start with 9!";
    }
    
    $date_now = date("Y-m-d");
    if ($update_dob >= $date_now) {
        $errors['update_dob'] = "Invalid date of birth!";
        
    }
    
    if ($update_c_start_date < $date_now) {
        $errors['update_c_start_date'] = "Start date should be today or later!";
        
    }
    
    if ($update_c_end_date <= $update_c_start_date) {
        $errors['update_c_end_date'] = "End date should be after the start date!";
       
    }



   
   
    if (empty($errors)) {
    $update_sql = "UPDATE trainee SET c_name = '$update_c_name', c_guardian_name ='$update_g_name', c_date_of_birth = '$update_dob', c_email = '$update_c_email', c_address = '$update_c_address', c_gender = '$update_c_gender', c_contact = '$update_c_contact', c_start_date = '$update_c_start_date', c_end_date = '$update_c_end_date', p_time = '$update_p_time', p_total_day = '$update_p_total_day', p_total_price = '$update_p_total_price' WHERE c_id ='$update_c_id'";
    $update_query = mysqli_query($conn, $update_sql) or die('query failed');

    if($update_query){
      
        $message = 'Trainee has been updated successfully!';
        // header('location:trainertotalstudent.php?message=' . urlencode(implode(",", $message)));

    }else{
        $message = 'Trainee could not be updated!' . mysqli_error($conn);
       

    }

    header('location:trainertotalstudent.php?message=' . urlencode( $message));
    exit(); // Ensure script execution stops here
   
}}

// Check if message is set in the URL
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>Document</title>
    <style>
        .error {
            color: red;
            font-size: 13px;
            text-align: left;
            font-family: serif;
        }
    </style>
</head>
<body>
    <!-- alert box -->

<?php if ($message): ?>
        <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'success' : ''; ?>">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
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

<!--------------------------------------------------Fetch Student -------------------------------------------------->
<div class= "list">
<section class="totalList">
    <table>
        <thead>
            <tr>
            <th>SNo.</th>
            <th>Name</th>
            <th>Guardain's Name</th>
            <th>DOB</th>
            <th>Email</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Contact</th>
            <th>Started Date</th>
            <th>End Date</th>
            <th>Time</th>
            <th>Total Days</th>
            <th>Total Price</th>
            <th>Assigned Trainer</th>
            <th>Actions</th>
            <th>Actions</th>
            <th></th>
            
             </tr>
        </thead>
        <tbody>
        <?php
            $select_trainee = mysqli_query($conn, "SELECT t.*, tr.trainer_name FROM trainee t LEFT JOIN trainers tr ON t.trainer_id = tr.trainer_id");
            $serial_no = 1; // Initialize serial number
            if ($select_trainee && mysqli_num_rows($select_trainee) > 0) {
                while ($row = mysqli_fetch_assoc($select_trainee)) {
            ?>
            <tr>
                <td><?php echo $serial_no++; ?></td>
                <td><?php echo $row['c_name']; ?></td>
                <td><?php echo $row['c_guardian_name']; ?></td>
                <td><?php echo $row['c_date_of_birth']; ?></td>
                <td><?php echo $row['c_email']; ?></td>
                <td><?php echo $row['c_address']; ?></td>
                <td><?php echo $row['c_gender']; ?></td>
                <td><?php echo $row['c_contact']; ?></td>
                <td><?php echo $row['c_start_date']; ?></td>
                <td><?php echo $row['c_end_date']; ?></td>
                <td><?php echo $row['p_time']; ?></td>
                <td><?php echo $row['p_total_day']; ?></td>
                <td><?php echo $row['p_total_price']; ?></td>
                <td><?php echo $row['trainer_name']; ?></td>
                <td>
                    <a href="trainertotalstudent.php?delete=<?php echo $row['c_id']; ?>" class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete?');"><i class="fa-sharp fa-solid fa-trash" ></i> Delete </a>
                </td>
                <td>
                    <a href="trainertotalstudent.php?edit=<?php echo $row['c_id']; ?>" class="option-btn"
                    onclick="return confirm('Are you sure you want to edit this?');"><i class="fa-solid fa-pen-to-square"></i>Update </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<span>No package added</span>";
            }
            ?>
        </tbody>
    </table>
</section>
        </div>


<!-----------------------------------editing------------------------------------------->
<div class="overlay" id="overlay"></div>

<section class="edit-student">
    <?php
    if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $edit_query = mysqli_query($conn, "SELECT * FROM trainee WHERE c_id = $edit_id") or die('query failed');
        if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
    ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="update_c_id" value="<?php echo $fetch_edit['c_id']; ?>">
                    <div>
                        <label>Name:</label>
                        <input type="text" class="box" required name="update_c_name" value="<?php echo $fetch_edit['c_name']; ?>">
                    </div>
                    <div>
                        <label>Guardian's Name:</label>
                        <input type="text" class="box" required name="update_g_name" value="<?php echo $fetch_edit['c_guardian_name']; ?>">
                    </div>
                    <div>
                        <label>Date of Birth:</label>
                        <input type="date" class="box" required name="update_dob" value="<?php echo $fetch_edit['c_date_of_birth']; ?>">
                        <?php if (isset($errors['update_dob'])) { echo '<span class="error">'.$errors['update_dob'].'</span>'; } ?>
                    </div>
                    <div>
                        <label>Email:</label>
                        <input type="email" class="box" required name="update_c_email" value="<?php echo $fetch_edit['c_email']; ?>">
                    </div>
                    <div>
                        <label>Address:</label>
                        <input type="text" class="box" required name="update_c_address" value="<?php echo $fetch_edit['c_address']; ?>">
                    </div>
                    <div>
                        <label>Gender:</label>
                        <input type="text" class="box" required name="update_c_gender" value="<?php echo $fetch_edit['c_gender']; ?>">
                    </div>
                    <div>
                        <label>Contact:</label>
                        <input type="number" class="box" required name="update_c_contact" value="<?php echo $fetch_edit['c_contact']; ?>">
                        <?php if (isset($errors['update_c_contact'])) { echo '<span class="error">'.$errors['update_c_contact'].'</span>'; } ?>
                    </div>
                    <div>
                        <label>Start Date:</label>
                        <input type="date" class="box" required name="update_c_start_date" value="<?php echo $fetch_edit['c_start_date']; ?>">
                        <?php if (isset($errors['update_c_start_date'])) { echo '<span class="error">'.$errors['update_c_start_date'].'</span>'; } ?>
                    </div>
                    <div>
                        <label>End Date:</label>
                        <input type="date" class="box" required name="update_c_end_date" value="<?php echo $fetch_edit['c_end_date']; ?>">
                        <?php if (isset($errors['update_c_end_date'])) { echo '<span class="error">'.$errors['update_c_end_date'].'</span>'; } ?>
                    </div>
                    <div class="inputbox">
                    <label>Time:</label>
                         <input type="radio" name="update_p_time" value="8:00AM To 9:00AM" <?php if(isset($fetch_edit['p_time']) && $fetch_edit['p_time'] == '8:00AM To 9:00AM') echo 'checked'; ?>>8:00AM To 9:00AM
                          <input type="radio" name="update_p_time" value="4:30PM To 5:30PM" <?php if(isset($fetch_edit['p_time']) && $fetch_edit['p_time'] == '4:30PM To 5:30PM') echo 'checked'; ?>>4:30PM To 5:30PM
                     </div>

                    <div>
                        <label>Total Days:</label>
                        <input type="number" class="box" required name="update_p_total_day" value="<?php echo $fetch_edit['p_total_day']; ?>">
                    </div>
                    <div>
                        <label>Total Price:</label>
                        <input type="number" class="box" required name="update_p_total_price" value="<?php echo $fetch_edit['p_total_price']; ?>">
                    </div>
                    <div class="button-container">
                    <input type="submit" value="Update" name="update_trainee" id="update_trainee" class="option-btn"><br><br>
                    <input type="button" value="Cancel" id="close-edit" class="option-btn">
                     </div>
                </form>
    <?php
            }
        }
    } else {
        echo '<script> document.querySelector(".edit-student").style.display = "none";</script>';
    }
    ?>
</section>

<script>

    document.querySelector('#close-edit').onclick = () => {
        document.querySelector('.edit-student').style.display = 'none';
        document.querySelector('#overlay').style.display = 'none';
        window.location.href = 'trainertotalstudent.php';
    }

    <?php if(isset($_GET['edit'])) { ?>
    document.querySelector('.edit-student').style.display = 'block';
    document.querySelector('#overlay').style.display = 'block';
    <?php } ?>

</script>
    
</body>
</html>