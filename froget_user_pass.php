<?php
$calert = false;
$uname_pname_alrt = false ; 
include('dbinfo.php');
if(isset($_POST['add'])){


  $uname = $_POST['uname'];
  $pname = $_POST['pname'];
  $pass = $_POST['pass'];
  $cpass = $_POST['cpass'];
if($pass == $cpass){


if($uname != "" && $pname != "" && $pass != "" && $cpass != ""){


  $select_que = "select count(*) from user_signup where username = '$uname' and primary_name = '$pname' ";
  $res = mysqli_query($con,$select_que);
$row = mysqli_fetch_array($res);
  if($row[0]>0){




$update_que = "update  user_signup set pasword = '$pass' , cpasword = '$cpass' where username = '$uname'";


 $update_que_res = mysqli_query($con,$update_que);


 if($update_que_res == true){
  header('location:user_login.php');
 }


























  }else{
    $uname_pname_alrt = true ;
  }
}
}else{
  $calert = true ; 
}
}
?>




<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">


  <title>Pages / Login - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  
  	<!-- -======================================== -->

	<!-- font awsome link -->


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- -======================================== -->

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>


<body>


<?php
  if($uname_pname_alrt){
  echo "<div class='alert alert-danger text-center' role='alert'>
  pelese check  username & primary_name  it's not match
  </div>";
  }
?>




<?php
  if($calert
  ){
  echo "<div class='alert alert-danger text-center' role='alert'>
  pelese check  password & conform password  it's not match
  </div>";
  }
?>




  <main>
    <div class="container">


      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">


            <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                <i  style="color: #fd7e14; font-size: 22px;" class="fa-solid fa-plane"></i>
                  <span class="d-none d-lg-block text-dark" style="margin-left: 20px;">Expense Voyage</span>
                </a>
              </div><!-- End Logo -->
              <div class="card mb-3">


                <div class="card-body">


                  <div class="pt-4 pb-2">
                    <h5  style="color: #fd7e14;" class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>


                       <!-- form start -->


                  <form class="row g-3 needs-validation" method="post" novalidate>




                  <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="uname" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>


                    <div class="col-12">
                      <label for="yourName" class="form-label">Enter Your primary school name</label>
                      <input type="text" name="pname" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, type  yourprimary school name!</div>
                    </div>






                    <div class="col-12">
                      <label for="yourPassword" class="form-label">New Password</label>
                      <input type="password" name="pass" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>


                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Conform Password</label>
                      <input type="password" name="cpass" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your conform  password !</div>
                    </div>










                    <div class="col-12">
                      <button  style="background-color: #fd7e14;" name="add" class="btn  w-100" type="submit">Login</button>
                    </div>




                    <div class="col-12">
                      <p class="small mb-0">Login here: <a href="user_login.php">Login </a></p>
                    </div>
                  </form>


                </div>
              </div>


              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
              </div>


            </div>
          </div>
        </div>


      </section>


    </div>
  </main><!-- End #main -->


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


</body>


</html>
