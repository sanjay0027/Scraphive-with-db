<?php
include 'config.php';

if (isset($_POST['orders'])) {

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
    $quantity = $_POST['quantity'];
    $quantity = filter_var($quantity, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $pickup_time = $_POST['pickup_time'];
    $pickup_time = filter_var($pickup_time, FILTER_SANITIZE_STRING);
 
    $scrapImg = $_FILES['scrapImg']['name'];
    $scrapImg = filter_var($scrapImg, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['scrapImg']['size'];
    $image_tmp_name = $_FILES['scrapImg']['tmp_name'];
    $image_folder = 'image/'.$scrapImg;
    $placed_on = date('Y-m-d H:i:s');
 
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
    $select_products->execute([$category]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(category, name, number, quantity, description, scrapImg, placed_on,pickup_time) VALUES(?,?,?,?,?,?,?,?)");
      $insert_products->execute([$category, $name, $number, $quantity, $description, $scrapImg, $placed_on,$pickup_time]);

      if($insert_products){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'new product added!';
         }

      }

   }

};
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Scrap Price Page - SCRAPHIVE</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon-32x32.png" rel="icon">
  <link href="assets/img/apple-touch-iconsh.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="./sellscrap.css" rel="stylesheet">

  <!-- chatbot -->
  <script>
    window.watsonAssistantChatOptions = {
      integrationID: "73a7371f-ed61-42b0-b30f-3d43f09673f0", // The ID of this integration.
      region: "eu-gb", // The region your integration is hosted in.
      serviceInstanceID: "495eb4d9-c93d-4bfb-b224-d6db4c7b1d35", // The ID of your service instance.
      onLoad: function(instance) { instance.render(); }
    };
    setTimeout(function(){
      const t=document.createElement('script');
      t.src="https://web-chat.global.assistant.watson.appdomain.cloud/versions/" + (window.watsonAssistantChatOptions.clientVersion || 'latest') + "/WatsonAssistantChatEntry.js";
      document.head.appendChild(t);
    });
  </script>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">SCRAPHIVE</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto " href="#hero"></a></li>
          <li><a class="nav-link scrollto" href="#about"></a></li>
          <li><a class="nav-link scrollto" href="#services"></a></li>
          <li><a class="nav-link scrollto " href="#portfolio"></a></li>
          <li><a class="nav-link scrollto" href="#team"></a></li>
          <li class="dropdown"><a href="#"></a>
          </li>
          <li><a class="getstarted scrollto"  href="scrappy.php">Check Rate List</a></li>
          <li><a class="nav-link scrollto active" href="sellscrap.php">Sell Scrap</a></li>
          <!-- <li><a class="getstarted scrollto"  href="./orderstatus.php">Order Status</a></li> -->
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
  <!-- End Header -->
<section>
<div class="containers">
    <form class="form" action="" method="post" enctype="multipart/form-data"><center>
        <h1>SELL YOUR SCRAPS</h1><br><br>
        <label >Scrap Domain *</label><br>
        <!-- <input type="text" id="title" name="title" class="box" placeholder="Enter the type of scrap" required><br><br> -->
               <select name="category" class="box" required>
                  <option value="Paper">Paper</option>
                  <option value="Plastic">Plastic</option>
                  <option value="Metal">Metal</option>
                  <option value="E-waste">E-waste</option>
                  <option value="Medical-waste">Medical-waste</option>
                  <option value="Other...">Other...</option>
                  
                </select><br><br>
      
        <label >Name *</label><br>
        <input type="text"  name="name" class="box" placeholder="Enter your name" required><br><br>
      
        <label >Scrap Image</label><br>
        <input type="file" name="scrapImg" class="Jags" placeholder="Choose your file" ><br><br>
      
        <label >Scrap Quantity (Approx*)</label><br>
        <input type="text" name="quantity" class="box"  placeholder="Enter the Quantity of scrap "><br><br>

        <label>Mobile Number</label><br>
        <input type="number" name="number" class="box" placeholder="Enter your Moblie number" required><br><br>
      
        <label >Address</label><br>
        <textarea name="description" class="box" placeholder="Enter your address" required></textarea><br><br>

        <label>Time Specific Delivery</label><br>
        <input name="pickup_time" class="box" placeholder=" 'morning'(8am-12pm),afternoon'(12pm-4pm)," required><br><br>
      
        <button type="submit" class="btn" name="orders">Request Sell Scrap</button></center>
    </form>
</div>
</section>
  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">

      <div class="container">

        <div class="row  justify-content-center">
          <div class="col-lg-6">
            <h3>SCRAPHIVE</h3>
            <p>The best place to sell your Scraps with best price.</p>
          </div>
        </div>

        <div class="social-links">
          <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
          <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
          <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
        </div>

      </div>
    </div>

    <div class="container footer-bottom clearfix">
      <div class="copyright">
        &copy; Copyright <strong><span>SCRAPHIVE</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!--  Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>