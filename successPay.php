<?php
session_start();
include('config.php');

if (isset($_SESSION['amount'])) {
    $amount = $_SESSION['amount'];
    $paid_date = date('Y-m-d'); 
    
    // $sql="SELECT id FROM customers";
    // $result=mysqli_query($conn,$sql);
    // $row=mysqli_fetch_assoc($result);
    // $client_id = $row['c_id'];

    if (isset($_SESSION['id'])) {
        $client_id = $_SESSION['id'];

    // Debugging output to verify values
    echo "Amount: " . htmlspecialchars($amount) . "<br>";
    echo "Paid Date: " . htmlspecialchars($paid_date) . "<br>";
    echo "Client ID: " . htmlspecialchars($client_id) . "<br>";

    // Prepare SQL statement to avoid SQL injection
    $sql = "INSERT INTO payment (amount, paid_date, status, c_id) VALUES (?, ?, 'paid', ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "dsi", $amount, $paid_date, $client_id); // Binding parameters
        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Record updated successfully");</script>';
            header("Location:insertDetail.php");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
} else {
    echo "Client ID not set in session.";
}
} else {
    echo "Amount not set in session.";
}



mysqli_close($conn);
?>
