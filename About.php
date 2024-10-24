<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>AboutUs Page</title>
</head>
<body class="aboutus">
    <!-- header part -->
     <?php
     include 'header2.php';
     ?>
 <!--..................................... body partttt.................................. -->
 <div class="description">
 <section class="about">
	<div class="image">	
		<img src="images/swim2.jpg">
	</div>

	<div class="content">
		<h3>Why us?</h3><br>
		<p>Club mandala Pvt. Ltd is a private company established in 2072 BS. 
            We are located at Ramnagar, Kathmandu. The club  
            aims to provide entertainment services along with facilities like public swimming pool and 
            swim training. We provide training facilities to interested trainees 6 days a week.
             The training is divided into 2 shifts from 9am to 10am morning and 4pm to 5pm evening. 
             The training comes in different packages of a week or 15 days or month, trainee can choose 
             according to their preferences. </p>

	</div>
	
</section>
</div>

<div class="gallery-section">
        <h3>WE OFFER</h3>
        <div class="gallery">
            <div class="gallery-item">
                <a target="_blank" href="images/pool.jpg">
                    <img src="images/pool.jpg" alt="Large Pool" width="300" height="300">
                </a>
                <div class="desc">Large Pool from 4ft up to 6.5ft</div>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="images/pool3.jpg">
                    <img src="images/pool3.jpg" alt="Baby Pool" width="300" height="300">
                </a>
                <div class="desc">A Baby pool of 2ft</div>
            </div>

            <div class="gallery-item">
                <a target="_blank" href="images/pool2.jpg">
                    <img src="images/pool2.jpg" alt="Training Packages" width="300" height="300">
                </a>
                <div class="desc">Training Packages</div>
            </div>
        </div>
    </div>


 <!-- Map Section -->
 <div class="map">
        <h3>Our Location</h3>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3531.556906422544!2d85.36077297447336!3d27.730963924451284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb1be79c09cc11%3A0x47a4932905171224!2sClub%20Mandala!5e0!3m2!1sen!2snp!4v1718718423837!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>


    <!-------------footer----------->
    <?php
    include 'footer.php';
    ?>




    
</body>
</html>