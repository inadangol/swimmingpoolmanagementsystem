<?php
session_start();
include 'config.php';
$error_msg = "";

if(isset($_GET['delete'])){
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete']); 
    $sql =  "DELETE FROM trainers WHERE trainer_id = $delete_id ";
    $delete_query = mysqli_query($conn, $sql);
    if($delete_query){
        echo "Trainer has been Removed";
        // header('location:totaltrainer.php');
    } else {
        echo "Trainer could not be removed. Error: " . mysqli_error($conn);
    }
}

if(isset($_POST['update_trainer'])){
    $update_trainer_id = $_POST['update_trainer_id'];
    
    $update_trainer_name =$_POST['update_trainer_name'];
    $update_trainer_email =$_POST['update_trainer_email'];
    $update_trainer_contact =$_POST['update_trainer_contact'];
    $update_trainer_address =$_POST['update_trainer_address'];
    $update_trainer_gender =$_POST['update_trainer_gender'];
    $update_trainer_salary =$_POST['update_trainer_salary'];

    $errors = [];

    // Validation for contact number
    if( !preg_match('/^9[0-9]{9}$/', $update_trainer_contact)) {
        $errors['update_trainer_contact'] = "Contact number should be 10 digits long and start with 9!";
       
    }
    
    // Validation for salary
 
  if ($update_trainer_salary <= 1 || $update_trainer_salary >= 100000) {
    $errors['update_trainer_salary'] = "Salary should be between $1 and $100,000!";
    }

if (empty($errors)) {
    $update_sql = "UPDATE trainers SET trainer_name = '$update_trainer_name', trainer_contact = '$update_trainer_contact', trainer_email = '$update_trainer_email', trainer_address = '$update_trainer_address' , trainer_gender = '$update_trainer_gender', trainer_salary = '$update_trainer_salary' WHERE trainer_id ='$update_trainer_id'";
    $update_query = mysqli_query($conn, $update_sql) or die('query failed');

    if($update_query){
        $message[] = 'Trainer has been updated successfully!';
    } else {
        $message[] = 'Trainer could not be updated! ' . mysqli_error($conn);
    }
    
    header('location:totaltrainer.php?message=' . urlencode(implode(",", $message)));
    exit();
}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Total Trainers</title>
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



<!----------------------------------------- side menu------------------------------------- -->
<?php
include 'adminheader.php';
?>

<!---------------------------------------- fetch trainers------------------------------------------------- -->
<div class= "list">
<section class="totalList">
    <table>
        <thead>
            <tr>
            <th>S.No</th>
            <th>Full Name</th>
            <th>Contact Number</th>
            <th>Email</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Salary</th>
            <th>Action</th>
            <th></th>
    </tr>
        </thead>
        <tbody>
            <?php
            $select_trainers = mysqli_query($conn, "SELECT * FROM trainers");
            $serial_no = 1; // Initialize serial number
            if(mysqli_num_rows($select_trainers) > 0){
                while($row = mysqli_fetch_assoc($select_trainers)){
            ?>
            <tr>
                <td><?php echo $serial_no++; ?></td>
                <td><?php echo $row['trainer_name']; ?></td>
                <td><?php echo $row['trainer_contact']; ?></td>
                <td><?php echo $row['trainer_email']; ?></td>
                <td><?php echo $row['trainer_address']; ?></td>
                <td><?php echo $row['trainer_gender']; ?></td>
                <td><?php echo $row['trainer_salary']; ?></td>
                <td>
                    <a href="totaltrainer.php?delete=<?php echo $row['trainer_id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete?');"><i class="fa-sharp fa-solid fa-trash"></i> Delete </a>
                </td>
                <td>
                    <a href="totaltrainer.php?edit=<?php echo $row['trainer_id']; ?>" class="option-btn"><i class="fa-solid fa-pen-to-square"></i> Update </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<span>No Trainer Added</span>";
            }
            ?>
        </tbody>
    </table>
</section>
</div>
<!------------------------------ overlay -------------------------->
<div class="overlay" id="overlay"></div>
<!------------------------------ editing trainer -------------------------->
<section class="edit-trainer" id="edit-trainer">
    <?php
    if(isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $edit_query = mysqli_query($conn, "SELECT * FROM trainers WHERE trainer_id = $edit_id") or die('query failed');
        if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_assoc($edit_query)){
    ?> 
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_trainer_id" value="<?php echo $fetch_edit['trainer_id']; ?>">
                <div>
                    <label>Trainer Name:</label>
                    <input type="text" class="box" required name="update_trainer_name" value="<?php echo $fetch_edit['trainer_name']; ?>">
                    <?php if(isset($errors['update_trainer_name'])) { echo '<span class="error">'.$errors['update_trainer_name'].'</span>'; } ?>
                </div>
                <div>
                    <label>Contact Number:</label>
                    <input type="tel" min="0" class="box" required name="update_trainer_contact" value="<?php echo $fetch_edit['trainer_contact']; ?>">
                    <?php if(isset($errors['update_trainer_contact'])) { echo '<span class="error">'.$errors['update_trainer_contact'].'</span>'; } ?>
                </div>
                
                
                <div>
                    <label>Email:</label>
                    <input type="email" class="box" required name="update_trainer_email" value="<?php echo $fetch_edit['trainer_email']; ?>">
                    <?php if(isset($errors['update_trainer_email'])) { echo '<span class="error">'.$errors['update_trainer_email'].'</span>'; } ?>
                </div>
                <div>
                    <label>Address:</label>
                    <input type="text" class="box" required name="update_trainer_address" value="<?php echo $fetch_edit['trainer_address']; ?>">
                    <?php if(isset($errors['update_trainer_address'])) { echo '<span class="error">'.$errors['update_trainer_address'].'</span>'; } ?>
                </div>
                <div>
                    <label>Gender:</label>
                    <input type="text" class="box" required name="update_trainer_gender" value="<?php echo $fetch_edit['trainer_gender']; ?>">
                    <?php if(isset($errors['update_trainer_gender'])) { echo '<span class="error">'.$errors['update_trainer_gender'].'</span>'; } ?>
                </div>
                <div>
                    <label>Salary:</label>
                    <input type="number" min="0" class="box" required name="update_trainer_salary" value="<?php echo $fetch_edit['trainer_salary']; ?>">
                    <?php if(isset($errors['update_trainer_salary'])) { echo '<span class="error">'.$errors['update_trainer_salary'].'</span>'; } ?>
                </div>
                <input type="submit" value="Update" name="update_trainer" id="update_trainer" class="option-btn">
                <input type="button" value="Cancel" id="close-edit" class="option-btn">
            </form>
    <?php
            }
        }
    } else {
        echo '<script> document.querySelector(".edit-trainer").style.display = "none";</script>';
    }
    ?>
</section> 

<script>
   

   
    document.querySelector('#close-edit').onclick = () => {
        document.querySelector('.edit-trainer').style.display = 'none';
        document.querySelector('#overlay').style.display = 'none';
        window.location.href = 'totaltrainer.php';
    }

    <?php if(isset($_GET['edit'])) { ?>
    document.querySelector('.edit-trainer').style.display = 'block';
    document.querySelector('#overlay').style.display = 'block';
    <?php } ?>

</script>

</body>
</html>
