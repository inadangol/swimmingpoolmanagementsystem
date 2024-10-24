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
        

     

        // Insert booking details into the database
        $c_name = $_SESSION['c_name'];
        $c_guardian_name = $_SESSION['c_guardian_name'];
        $c_address= $_SESSION['c_address'];
        $c_date_of_birth= $_SESSION['c_date_of_birth'];
        $c_email = $_SESSION['c_email'];
        $c_gender = $_SESSION['c_gender'];
        $c_contact = $_SESSION['c_contact'];
        $c_start_date = $_SESSION['c_start_date'];
        $c_end_date = $_SESSION['c_end_date'];
        $p_time = $_SESSION['p_time'];
        $trainer_id = $_SESSION['trainer_id'];

        // echo $c_address.$c_contact;

       
        $detail_query = mysqli_query($conn, "INSERT INTO trainee(c_name, c_guardian_name, c_address, c_date_of_birth, c_email, c_gender, c_contact, c_start_date, c_end_date, p_total_day, p_total_price, trainer_id)
                                   VALUES('$c_name', '$c_guardian_name', '$c_address', '$c_date_of_birth', '$c_email', '$c_gender', '$c_contact', '$c_start_date', '$c_end_date', '$p_total_day', '$p_total_price' ,'$trainer_id')") or die('query failed');

        if($detail_query){
             header('location: displaydetaill.php');
            } 
            else {
                echo "Error: " . mysqli_error($conn);
            }     
                       
}else{
        echo "Form not sent";
        exit();
    }
  
?>
