<?php
    include('config.php');
    session_start();


    if(isset($_SESSION['package_id'])) {
        $package_id = $_SESSION['package_id'];
        $query = "SELECT * FROM packages WHERE p_id = $package_id";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0) {
            $package = mysqli_fetch_assoc($result);
        } else {
            echo "Package not found!";
            exit();
        }
    } else {
        echo "Package ID not provided!";
        exit();
    }
    if(isset($package)){
            $p_total_day = $package['p_day'];
            $p_total_price = $package['p_price'];
            
            if(isset($_POST['book_now'])){
                $_SESSION['c_name']= $_POST['c_name'];
                $_SESSION['c_guardian_name'] = $_POST['c_guardian_name'];
                $_SESSION['c_address']= $_POST['c_address'];
                $_SESSION['c_date_of_birth']= $_POST['c_date_of_birth'];
                $_SESSION['c_email'] = $_POST['c_email'];
                $_SESSION['c_gender'] = $_POST['c_gender'];
                $_SESSION ['c_contact']= $_POST['c_contact'];
                $_SESSION ['c_start_date']= $_POST['c_start_date'];
                $_SESSION['c_end_date']= $_POST['c_end_date'];
                $_SESSION['p_time'] = $_POST['p_time'];
                $_SESSION['trainer_id']= $_POST['trainer_id'];
                
                if(isset($_SESSION['c_name'])){
                    header('location:completeBooking.php');
                }
            }
      }  else{
            echo "Package not found!";
            exit();
      }
    
?>
