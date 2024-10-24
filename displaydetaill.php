
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
        <title>displaydetail</title>
    </head>
    <body>
    
    <?php
      session_start();
      include 'config.php';

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
            

$p_total_day = $package['p_day'];
$p_total_price = $package['p_price'];
$package_details= $package['p_description'];

if (isset($_SESSION['trainer_id'])) {
        $trainer_id=$_SESSION['trainer_id'];
        $trainer_query = mysqli_query($conn, "SELECT trainer_name FROM trainers WHERE trainer_id = $trainer_id");
     
    if ($trainer_query && mysqli_num_rows($trainer_query) > 0) {
         $trainer = mysqli_fetch_assoc($trainer_query);
         $trainer_name = $trainer['trainer_name'];
    
        } else {
         echo "Trainer not found!";
         exit();
     }
    } else {
        echo "Trainer ID not provided!";
        exit();
    }
        
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


     
        echo" 
         <div class='booked-message-container'>
            <div class='message-container'>
                <h3>Thank You for Joining us!</h3>
                <div class='book-detail'>
                    <span>" . $package_details . "</span> <br><br>
                    <span class='total'>Total Days:" . $p_total_day . "</span> <br><br>
                    <span class='total'>Total: Rs" . $p_total_price . "/-</span>
                </div>
                <div class='trainee-detail'>
                    <p>Your Name: <span>" . $c_name . "</span></p>
                    <p>Your Guardian's Name: <span>" . $c_guardian_name . "</span></p>
                    <p>Your Address: <span>" . $c_address . "</span></p>
                    <p>Your DOB: <span>" . $c_date_of_birth . "</span></p>
                    <p>Your Email: <span>" . $c_email . "</span></p>
                    <p>Your Gender: <span>" . $c_gender . "</span></p>
                    <p>Your Contact: <span>" . $c_contact . "</span></p>
                    <p>Your Started-Date: <span>" . $c_start_date . "</span></p>
                    <p>Your End-Date: <span>" . $c_end_date . "</span></p>
                    <p>Your Time: <span>" . $p_time . "</span></p>
                    <p>Trainer name: <span>".$trainer_name. "</span></p>
                </div>
                <a href='Package.php' class='btn'>Finish</a>
                <a href='pastBookings.php'>See Past Bookings</a>
                </div>
        </div>";
        ?>
        
    </body>
    </html>