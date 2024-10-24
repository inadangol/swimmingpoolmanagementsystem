
<?php
include 'config.php';


if(isset($_POST['update_package'])){
    $update_p_id = mysqli_real_escape_string($conn, $_POST['update_p_id']);
    $update_p_name = mysqli_real_escape_string($conn, trim($_POST['update_p_name']));
    $update_p_day = mysqli_real_escape_string($conn, $_POST['update_p_day']);
    $update_p_price = mysqli_real_escape_string($conn, $_POST['update_p_price']);
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_old_image = $_POST['update_old_image'];
    $update_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_folder = 'uploaded_img/' . $update_p_image;

    // validation
    $errors = [];

    if (empty($update_p_name)) {
        $errors[] = 'Package name is required.';
    }

    if ($update_p_day <= 1) {
        $errors[] = 'Day must be a positive number.';
    }

    if ($update_p_price <= 1) {
        $errors[] = 'Price must be a positive number.';
    }

    if (!empty($update_p_image)) {
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = pathinfo($update_p_image, PATHINFO_EXTENSION);

        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = 'Only .jpg, .jpeg, .png file formats are allowed.';
        }
    } else {
        $errors[] = 'An image must be selected.';
    }

    if (empty($errors)) {
        $update_sql = "UPDATE packages SET p_name = '$update_p_name', p_price = '$update_p_price', p_day = '$update_p_day' WHERE p_id ='$update_p_id'";
        $update_query = mysqli_query($conn, $update_sql);

        if($update_query){
            if ($_FILES['update_p_image']['error'] === 0) {
                $old_image_path = 'uploaded_img/' . $update_old_image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
                move_uploaded_file($update_image_tmp_name, $update_folder);
            }
            $message[] = 'Product has been updated successfully!';
        } else {
            $message[] = 'Product could not be updated! ' . mysqli_error($conn);
        }
    } else {
        $message = $errors;
    }
    
    header('location:totalpackages.php?message=' . urlencode(implode(",", $message)));
    exit();
}

if(isset($_GET['delete'])){
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete']);
    if(is_numeric($delete_id) && $delete_id > 0) {
        $sql =  "DELETE FROM packages WHERE p_id = $delete_id";
        $delete_query = mysqli_query($conn, $sql);
        if($delete_query){
            echo "Package Deleted";
        } else {
            echo "Package could not be deleted. Error: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Total Packages</title>
</head>
<body>

<?php
if(isset($message)){
    echo "<div>" . $message . "</div>";
}
?>
<?php
if(isset($message) && is_array($message)){
    foreach ($message as $msg) {
        echo "<div>" . htmlspecialchars($msg) . "</div>";
    }
} elseif (isset($message)) {
    echo "<div>" . htmlspecialchars($message) . "</div>";
}
?>

<!-----------------------------------------header------------------------------------- -->

<?php
include 'adminheader.php';
?>


<!---------------------------------------- fectch package------------------------------------------------- -->
<div class= "list">
<section class="totalList">
    <table>
        <thead>
            <tr>
            <th>Image</th>
            <th>Package Name</th>
            <th>Total Day</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
            <th></th>
</tr>
        </thead>
        <tbody>
            <?php
            $select_packages = mysqli_query($conn, "SELECT * FROM packages");
            if(mysqli_num_rows($select_packages) > 0){
                while($row = mysqli_fetch_assoc($select_packages)){
            ?>
            <tr>
                <td><img src="<?php echo "uploaded_img/".$row['p_image']; ?>" height="150" width="150" alt=""></td>
                <td><?php echo $row['p_name']; ?></td>
                <td><?php echo $row['p_day']; ?></td>
                <td><?php echo $row['p_description']; ?></td>
                <td><?php echo $row['p_price']; ?></td>
                <td>
                    <a href="totalpackages.php?delete=<?php echo $row['p_id']; ?>" class="delete-btn"
                    onclick="return confirm('Are you sure you want to delete this?');"><i class="fa-sharp fa-solid fa-trash"></i> Delete </a>
                </td>
                <td>
                    <a href="totalpackages.php?edit=<?php echo $row['p_id']; ?>" class="option-btn"
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

<!------------------------------ editing package -------------------------->

<section class="edit-package">
    <?php
    if(isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $edit_query = mysqli_query($conn, "SELECT * FROM packages WHERE p_id = $edit_id") or die('query failed');
        if(mysqli_num_rows($edit_query) > 0){
            while($fetch_edit = mysqli_fetch_assoc($edit_query)){
    ?>
            <form action="" method="post" enctype="multipart/form-data">
                <img src="uploaded_img/<?php echo $fetch_edit['p_image']; ?>" height="150" width="150" alt=""> <br>
                <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['p_id']; ?>">
                <input type="hidden" name="update_old_image" value="<?php echo $fetch_edit['p_image']; ?>">
                Package Name: <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['p_name']; ?>">
                Day: <input type="number" min="0" class="box" required name="update_p_day" value="<?php echo $fetch_edit['p_day']; ?>">
                Price: <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['p_price']; ?>">
                Image: <input type="file" min="0" class="box" required name="update_p_image" accept="image/png, image/jpg, image/jpeg">
                <input type="submit" value="Update"  name="update_package" id="update_package" class="option-btn">
                <input type="button" value="Cancel" id="close-edit" class="option-btn">
            </form>
    <?php
            }
        }
    } else {
        echo '<script> document.querySelector(".edit-package").style.display = "none";</script>';
    }
    ?>
</section>

    
    
    
    
    
    <script>
        document.querySelector('#close-edit').onclick = () =>{
        document.querySelector('.edit-package').style.display = 'none';
        window.location.href = 'totalpackages.php';
        }
    </script>




</body>
</html>