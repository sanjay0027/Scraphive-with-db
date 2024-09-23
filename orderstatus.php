<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:');
}

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
  <!-- <link href="./sellscrap.css" rel="stylesheet"> -->
  <link href="./orderstatus.css" rel="stylesheet">
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
          <li><a class= "getstarted scrollto"   href="sellscrap.php">Sell Scrap</a></li>
          <li><a class="nav-link scrollto active"  href="orderstatus.php">Order Status</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
  <!-- End Header -->
  <section class="placed-orders">

<h1 class="title">placed orders</h1>

<div class="box-container" style="align-items: center;
    justify-content: center;">

   <?php
   $select_orders = $conn->prepare("SELECT * FROM `products` WHERE user_id = ?");
   $select_orders->execute([$user_id]);
   if ($select_orders->rowCount() > 0) {
      while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
   ?>
         <div class="box" >
                  <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
                  <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
                  <p> title : <span><?= $fetch_orders['category']; ?></span> </p>
                  <p> quantity : <span><?= $fetch_orders['quantity']; ?></span> </p>
                  <p> Number : <span><?=$fetch_orders['number'];?></span></p>
                  <p> address : <span><?= $fetch_orders['description']; ?></span> </p>
                  <p> Order Placed on: <span><?= $fetch_orders['placed_on']; ?></span> </p>
                  <p> Pickup Time: <span><?= $fetch_orders['pickup_time']; ?></span> </p>
            <!-- <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                         echo 'red';
                                                      } else {
                                                         echo 'green';
                                                      }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p> -->
         </div>
   <?php
      }
   } else {
      echo '<center><p class="empty">Your order is not placed yet!</p></center>';
   }
   ?>

</div></center>

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