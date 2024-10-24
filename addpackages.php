<head>
    <style>
        .package {
    margin-left: 250px;
    padding: 20px;
}

.add-product-form {
    max-width: 400px;
    margin: auto;
}

.add-product-form h3 {
    margin-bottom: 20px;
}

.add-product-form label {
    font-weight: bold;
}

.add-product-form .box {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.add-product-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.add-product-form .bttn {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.add-product-form .bttn:hover {
    background-color: #45a049;
}


    </style>
</head>




<?php
session_start();
include 'config.php';
$message = "";


if(isset($_POST['add_product'])){
    $p_name = $_POST['p_name'];
    $p_description = $_POST['p_description'];
    $p_day = $_POST['p_day'];
    $p_price = $_POST['p_price'];
    $p_image = $_FILES['p_image']['name'];

    if($p_price < 0 || $p_day < 0 ) {
       $error_msg= "Price or date cannot be a negative value!";
        header("Location: addpackages.php?error_msg=" . urlencode($error_msg));
    } else {
    

    //image code
    $target = "uploaded_img/";
    $target_file = $target . basename($p_image);

    $uploadOK=1;

    $check = getimagesize($_FILES['p_image']['tmp_name']);

   if($check !== false){
        $uploadOK = 1;
    }

    else{
        echo "File is not an image!";
        $uploadOK = 0;
    }

    if(file_exists($target_file)){
        echo"Sorry file already exists";
        $uploadOK = 0;
    }
    //   if($uploadOk == 0){
    //     echo "Sorry file not uploaded!";
    //  }
     else{
        if(move_uploaded_file($_FILES['p_image']['tmp_name'], $target_file)){
            echo "The file " . htmlspecialchars(basename($_FILES['p_image']['name'])) . " has been uploaded successfully!";
        
        $product_image = htmlspecialchars(basename($_FILES['p_image']['name']));

       $insert_query = "INSERT INTO packages(p_name, p_description, p_day, p_price, p_image) VALUES 
                         ('$p_name','$p_description','$p_day','$p_price','$product_image')";


     if(mysqli_query($conn, $insert_query)){
        $message = "New record inserted successfully!";
     }
     else{
        $message = "Error: " . mysqli_error($conn);
     }
    }
    
     else{
        echo "Sorry, there was an error uploading your file!";
     }


}

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
    <title>Add Packages</title>
</head>
<body>

      <!-- alert box -->

<?php if ($message): ?>
        <div class="alert <?php echo strpos($message, 'successfully') !== false ? 'success' : ''; ?>">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
  <!-- ........side menu...... -->
      <div class="side-menu">
        <div class="logo">
           <a href="dashboard.php">
			  <img src="images\logo2.png" alt="logo2" />
		   </a>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fa-regular fa-table-columns"></i>&nbsp; Dashboard</a></li>
            <li><a href="studentapayment.php"><i class="fa-solid fa-person-swimming"></i>&nbsp; Students</a></li>
            <li><a href="registertrainer.php"><i class="fa-solid fa-person"></i>&nbsp; Trainer</a></li>
            <li><a href="addpackages.php"><i class="fa-solid fa-box-archive"></i>&nbsp; Packages</a></li>
            <!-- <li><a href="totalpackages.php"><i class="fa-solid fa-box-archive"></i>&nbsp; Packages</a></li> -->
        </ul>
    </div> 


  <div class="package">
    <section>
        <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
            <h3>Add New Package</h3>

            <label>Package Name:</label>
            <input type="text" name="p_name" placeholder="Enter the package name" class="box" required><br><br>

            <label>Description</label>
           <textarea name="p_description" class="box" placeholder="write something" cols="40" rows="10"></textarea><br><br>

            <label>Total Days:</label>
            <input type="number" name="p_day" placeholder="Enter days" class="box" required><br><br>
            
            <label>Price:</label>
            <input type="number" name="p_price" placeholder="Enter price" class="box" required><br><br>
            <?php
        if(isset($_GET['error_msg'])){
            $invalid_msg = $_GET['error_msg'];
            echo "<div style='color:red; font-size:13px; text-align:center; font-family:serif;'> $invalid_msg </div>";
          
        }


        ?>

            
            <label>Image:</label>
            <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required><br><br>
            
            <input type="submit" value="Add Product" name="add_product" class="bttn">
        </form>

        <!-- <button class="delete-button">Delete</button> -->

      
    </section>
</div>






<!-- js file link -->
<script src="js/script.js"></script>
    
</body>
</html>