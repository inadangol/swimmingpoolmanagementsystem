<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
        <title>Document</title>
</head>
<body>
    
<!---------------------- header ------------------>
<?php
include 'header.php';
?>

<!-------------------------packages------------------- -->
<div class="package-body">
    <h1 class="pHeading">Availabe Packages</h1>
    <div class="package-container">
        <?php

        $select_packages = mysqli_query($conn,"SELECT * FROM packages");
         if(mysqli_num_rows($select_packages) > 0){
            while($fetch_packages = mysqli_fetch_assoc($select_packages)){
                ?>

                <form action="Bookpack.php" method="post">
                    <div class="left-box">
                     <img src="uploaded_img/<?php echo $fetch_packages['p_image']; ?>" alt="">
                    </div>
                    <div class="right-box">
                        <h3><?php echo $fetch_packages['p_name']; ?></h3>
                        <h4 class="discription"> <?php echo $fetch_packages['p_description']; ?></h4>
                        <div class="day">Total Days: <?php echo $fetch_packages['p_day']; ?></div>
                        <div class="price">Rs<?php echo $fetch_packages['p_price']; ?>/- </div>
                        <input type="hidden" name="p_name" value="<?php echo $fetch_packages['p_name']; ?>">
                        <input type="hidden" name="p_description" value="<?php echo $fetch_packages['p_description']; ?>">
                        <input type="hidden" name="p_day" value="<?php echo $fetch_packages['p_day']; ?>">
                        <input type="hidden" name="p_price" value="<?php echo $fetch_packages['p_price']; ?>">
                        <button onclick="document.location='Bookpack.php?package_id=<?php echo $fetch_packages['p_id']; ?>'" type="button" class="btn" name="book_packages">Book Package</button>

                     

                        



                   
                    </div>
                </form>




          <?php
            }
         }

        
        ?>

    </div>

</div>
    
</body>
</html>