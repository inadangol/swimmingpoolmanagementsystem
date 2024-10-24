<?php
session_start();
include 'config.php';
$error_msg= "";


if(isset($_GET['package_id'])) {
    $_SESSION['package_id']=$_GET['package_id'];
    $package_id = $_GET['package_id'];
    $query = "SELECT * FROM packages WHERE p_id = $package_id";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $package = mysqli_fetch_assoc($result);
    } else {
        echo "Package not found!";
    }
} else {
    echo "Package ID not provided!";
}


// book package by filling form
if(isset($_POST['book_now'])){
    $c_name = $_POST['c_name'];
    $c_guardian_name = $_POST['c_guardian_name'];
    $c_address= $_POST['c_address'];
    $c_date_of_birth= $_POST['c_date_of_birth'];
    $c_email = $_POST['c_email'];
    $c_gender = $_POST['c_gender'];
    $c_contact = $_POST['c_contact'];
    $c_start_date = $_POST['c_start_date'];
    $c_end_date = $_POST['c_end_date'];
    $p_time = $_POST['p_time'];
    $trainer_id = $_POST['trainer_id'];


// Validation
    $errors = [];

if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
    $errors['c_email'] = "Invalid email format!";
  
}

if (strlen($c_contact) != 10 || !preg_match('/^[9][0-9]{9}$/', $c_contact)) {
    $errors['c_contact'] = "Contact number should be 10 digits long and start with 9!";
}

$date_now = date("Y-m-d");
if ($c_date_of_birth >= $date_now) {
    $errors['c_date_of_birth'] = "Invalid date of birth!";
    
}

if ($c_start_date < $date_now) {
    $errors['c_start_date'] = "Start date should be today or later!";
    
}

if ($c_end_date <= $c_start_date) {
    $errors['c_end_date'] = "End date should be after the start date!";
   
}


     
    
    
    // Fetch the trainer's name using the trainer_id
     $trainer_query = mysqli_query($conn, "SELECT trainer_name FROM trainers WHERE trainer_id = $trainer_id");
     if ($trainer_query && mysqli_num_rows($trainer_query) > 0) {
         $trainer = mysqli_fetch_assoc($trainer_query);
         $trainer_name = $trainer['trainer_name'];
     } else {
         echo "Trainer not found!";
         exit();
     }

     if(isset($package)){
        // while($package_item = mysqli_fetch_assoc($package_query)){
            $package_name = $package['p_name'];
            $package_day = $package['p_day'];
            $p_total_day = $package_day;
            $package_price = $package['p_price'];
            $p_total_price = $package_price;
            $package_details = $package_name;
        
        }else{
            echo "Package not found!";
            exit();
      }
    }

 ?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book package by trainee</title>
    <style>
        .error {
            color: red;
            font-size: 13px;
            text-align: left;
            font-family: serif;
        }
    </style>
</head>
<body class="login-page">
<?php include 'header.php'; ?>

<section class="booking-form">
    <h1 class="heading">Book Your Package</h1>
   
    <form action="creatingSession.php" method="post">
        <div class="booking-details">
            <h2>Booking Details</h2>
            <?php if (isset($package)) : ?>
            <h3>Package Name: <?php echo $package['p_name']; ?></h3>
            <p>Total Day: <?php echo $package['p_day']; ?></p>
            <p>Description: <?php echo $package['p_description']; ?></p>
            <p>Price: <?php echo $package['p_price']; ?></p>
        </div>

        <section class="form">
            <div class="inputbox">
                <span>Name:</span>
                <input type="text" placeholder="enter your name" name="c_name" value="<?php echo htmlspecialchars($c_name ?? ''); ?>" required>
            </div>
            <div class="inputbox">
                <span>Guardian's Name:</span>
                <input type="text" placeholder="enter your guardian's name" name="c_guardian_name" value="<?php echo htmlspecialchars($c_guardian_name ?? ''); ?>" required>
            </div>
            <div class="inputbox">
                <span>Date-Of-Birth:</span>
                <input type="date" placeholder="enter your date-of-birth" name="c_date_of_birth" value="<?php echo htmlspecialchars($c_date_of_birth ?? ''); ?>" required>
                <?php if (isset($errors['c_date_of_birth'])) { echo '<span class="error">'.$errors['c_date_of_birth'].'</span>'; } ?>
            </div>
            <div class="inputbox">
                <span>Gender:</span>
                <input type="radio" name="c_gender" value="Male" <?php if (($c_gender ?? '') == 'Male') echo 'checked'; ?> required>Male
                <input type="radio" name="c_gender" value="Female" <?php if (($c_gender ?? '') == 'Female') echo 'checked'; ?> required>Female
                <input type="radio" name="c_gender" value="Others" <?php if (($c_gender ?? '') == 'Others') echo 'checked'; ?> required>Others
            </div>
            <div class="inputbox">
                <span>Address:</span>
                <input type="text" placeholder="enter your address" name="c_address" value="<?php echo htmlspecialchars($c_address ?? ''); ?>" required>
            </div>
            <div class="inputbox">
                <span>Email:</span>
                <input type="text" placeholder="enter your email" value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>" name="c_email" required readonly>
                <?php if (isset($errors['c_email'])) { echo '<span class="error">'.$errors['c_email'].'</span>'; } ?>
            </div>
            <div class="inputbox">
                <span>Contact:</span>
                <input type="tel" placeholder="enter your contact" name="c_contact" value="<?php echo htmlspecialchars($c_contact ?? ''); ?>" required>
                <?php if (isset($errors['c_contact'])) { echo '<span class="error">'.$errors['c_contact'].'</span>'; } ?>
            </div>
            <div class="inputbox">
                <span>Time:</span>
                <input type="radio" name="p_time" value="8:00AM To 9:00AM" <?php if (($p_time ?? '') == '8:00AM To 9:00AM') echo 'checked'; ?> required>8:00AM To 9:00AM
                <input type="radio" name="p_time" value="4:30PM To 5:30PM" <?php if (($p_time ?? '') == '4:30PM To 5:30PM') echo 'checked'; ?> required>4:30PM To 5:30PM
            </div>
            <div class="inputbox start-date">
                <span>Start-Date:</span>
                <input type="date" placeholder="Start-Date" name="c_start_date" value="<?php echo htmlspecialchars($c_start_date ?? ''); ?>" required>
                <?php if (isset($errors['c_start_date'])) { echo '<span class="error">'.$errors['c_start_date'].'</span>'; } ?>
            </div>
            <div class="inputbox end-date">
                <span>End-Date:</span>
                <input type="date" placeholder="End-Date" name="c_end_date" value="<?php echo htmlspecialchars($c_end_date ?? ''); ?>" required>
                <?php if (isset($errors['c_end_date'])) { echo '<span class="error">'.$errors['c_end_date'].'</span>'; } ?>
            </div>

             <!-- Trainer selection dropdown -->
            <label for="trainer">Assign Trainer:</label>
            <select name="trainer_id" required>
            <option value="">Select Trainer</option>
               <?php
                $select_trainers = mysqli_query($conn, "SELECT * FROM trainers");
                if ($select_trainers) {
                while ($trainer = mysqli_fetch_assoc($select_trainers)) {
                // $selected = ($fetch_edit['trainer_id'] == $trainer['trainer_id']) ? 'selected' : '';
                echo "<option value='{$trainer['trainer_id']}'>{$trainer['trainer_name']}</option>";
                }
               }
              ?>
             </select>


              <input type="submit" value="Confirm Booking" name="book_now" class="btn">

        </section>

    </form>

</section>

<?php else : 
    ?>
    <p>Package not found!</p>
    <?php endif; 
    ?>
    </div>

    
</body>
</html>