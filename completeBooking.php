<?php
include 'config.php';
session_start();
$package_id=$_SESSION['package_id'];
$sql="SELECT p_price FROM packages where p_id=$package_id";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$amount = $row['p_price'];

// $amount = $_GET['amount'];
// echo $amount;
$_SESSION['amount']=$amount;
$tax=0;
$total_amount = $amount + $tax;
// echo $total_amount;
$transaction_uuid = uniqid();
$secret = '8gBm/:&EnhH.1/q';
$Message = "total_amount=$total_amount,transaction_uuid=$transaction_uuid,product_code=EPAYTEST";
$s = hash_hmac('sha256', $Message, $secret, true);
$a = base64_encode($s); // Convert binary output to hexadecimal
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container input[type="text"],
        .form-container input[type="hidden"],
        .form-container input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-container input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Pay for Swimming Course with Esewa</h2>
    
 <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
 <input type="text" id="amount" name="amount" value="<?php echo $amount; ?>" required readonly>
 <input type="text" id="tax_amount" name="tax_amount" value ="<?php echo $tax; ?>" required readonly>
 <input type="text" id="total_amount" name="total_amount" value="<?php echo $total_amount; ?>" required readonly>
 <input type="hidden" id="transaction_uuid" name="transaction_uuid" value="<?php echo $transaction_uuid; ?>" required>
 <input type="hidden" id="product_code" name="product_code" value ="EPAYTEST" required>
 <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
 <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
 <input type="hidden" id="success_url" name="success_url" value="http://localhost/swimmingpool/successPay.php" required>
 <input type="hidden" id="failure_url" name="failure_url" value="https://google.com" required>
 <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
 <input type="hidden" id="signature" name="signature" value="<?php echo $a; ?>" required>
 <input value="Submit" type="submit">
 </form>
 </div>
</body>
</html>
