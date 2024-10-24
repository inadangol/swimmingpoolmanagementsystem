<?php
session_start();
include 'config.php';




if(isset($_GET['delete'])){
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete']);
    if(is_numeric($delete_id) && $delete_id > 0) {
        $sql =  "DELETE FROM payment WHERE payment_id = $delete_id";
        $delete_query = mysqli_query($conn, $sql);
        if($delete_query){
            echo "Payment Deleted";
        } else {
            echo "Payment could not be deleted. Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid package ID.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleadmin.css">
    <title>payment details</title>
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
            <th>S.No</th>
            <th>Full Name</th>
            <th>Amount</th>
            <th>Paid Date</th>
            <th>Status</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php
            // Define the query
            $query = "
                SELECT p.*, c.name 
                FROM payment p 
                JOIN customers c ON p.c_id = c.id
            ";

            // Execute the query
            $total_payment = mysqli_query($conn, $query);

            // Check for query execution errors
            if (!$total_payment) {
                die('Query Failed: ' . mysqli_error($conn));
            }

            // Initialize serial number
            $serial_no = 1;

            // Check if there are any rows returned
            if (mysqli_num_rows($total_payment) > 0) {
                while ($row = mysqli_fetch_assoc($total_payment)) {
            ?>
            <tr>
                <td><?php echo $serial_no++; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['amount']); ?></td>
                <td><?php echo htmlspecialchars($row['paid_date']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <a href="studentapayment.php?delete=<?php echo $row['payment_id']; ?>" class="delete-btn"
                       onclick="return confirm('Are you sure you want to delete this?');">
                       <i class="fa-sharp fa-solid fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<span>No Payment Made</span>";
            }
            ?>
        </tbody>
    </table>
</section>
        </div>

    
</body>
</html>