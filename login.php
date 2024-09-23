<?php

include 'config.php';

if(isset($_POST['SignUp'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);


   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'user email already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?,?,?)");
         $insert->execute([$name, $email, $pass]);
         $message[] = 'registered successfully!';
         //  header('location:login.php');
            
         }

      }
   }

?>

<?php

@include 'config.php';

session_start();

if(isset($_POST['SignIn'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_id'] = $row['id'];
         header('location:scrappy.php');

      }else{
         $message[] = 'no user found!';
      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Log In / Sign Up | SCRAPHIVE</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"
    />
    <link 
      rel="stylesheet"
      href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css"
    />
    <link rel="stylesheet" href="./loginStyle.css" />


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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
  <?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message" style=".alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
      }
      
      .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
      }
      
      .closebtn:hover {
        color: black;
      }">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
    
          <h1 class="logo"><a href="index.php">SCRAPHIVE</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    
          <nav id="navbar" class="navbar">
            <ul>
              <li><a class="nav-link scrollto" href="#">Login Page</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav>
          <!-- .navbar -->
    
        </div>
    </header>
    <!-- End Header -->
    <!-- partial:index.partial.html -->
    <div class="section">
      <div class="container">
        <div class="row full-height justify-content-center">
          <div class="col-12 text-center align-self-center py-5">
            <div class="section pb-5 pt-5 pt-sm-2 text-center" style="margin-top: 6rem;">
              <h6 class="mb-0 pb-3" style="margin-top: 5rem;">
                <span>Log In </span><span>Sign Up</span>
              </h6>
              <input
                class="checkbox"
                type="checkbox"
                id="reg-log"
                name="reg-log"
              />
              <label for="reg-log"></label>
              <div class="card-3d-wrap mx-auto">
                <div class="card-3d-wrapper">
                  <div class="card-front">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 class="mb-4 pb-3" style="color: white;">Log In</h4>
                        <form action="" method="POST">
                        <div class="form-group">
                          <input
                            type="email"
                            name="email"
                            class="form-style"
                            placeholder="Your Email"
                            autocomplete="on"
                            Required
                          />
                          <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input
                            type="password"
                            name="pass"
                            class="form-style"
                            placeholder="Your Password"
                            autocomplete="on"
                            Required

                          />
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <input type="submit" value="SignIn" class="btn mt-4" style="background-color: #156DD7; color: white;" name="SignIn">
                        <!-- <a href="scrap-price-page.html" class="btn mt-4" style="background-color: #156DD7; color: white;">submit</a> -->
                        <p class="mb-0 mt-4 text-center">
                          <!-- <a href="#0" class="link">Forgot your password?</a> -->
                        </p>
                      </div>
</form>
                    </div>
                  </div>
                  <div class="card-back">
                    <div class="center-wrap">
                      <div class="section text-center">
                        <h4 class="mb-4 pb-3" style="color: white;">Sign Up</h4>
                        <form action="" method="POST">
                        <div class="form-group">
                          <input
                            type="text"
                            name="name"
                            class="form-style"
                            placeholder="Your Full Name"
                            autocomplete="on"
                            Required

                          />
                          <i class="input-icon uil uil-user"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input
                            type="email"
                            name="email"
                            class="form-style"
                            placeholder="Your Email"
                            autocomplete="on"
                            Required

                          />
                          <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input
                            type="password"
                            name="pass"
                            class="form-style"
                            placeholder="Your Password"
                            autocomplete="on"
                            Required

                          />
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input
                            type="password"
                            name="cpass"
                            class="form-style"
                            placeholder="Re-enter your Password"
                            autocomplete="on"
                            Required

                          />
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <input type="submit" value="SignUp" class="btn mt-4" style="background-color: #156DD7; color: white;" name="SignUp">
                        <!-- <a href="scrap-price-page.html" class="btn mt-4" style="background-color: #156DD7; color: white;">submit</a> -->
    </form> 
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- partial -->
  </body>
</html>
