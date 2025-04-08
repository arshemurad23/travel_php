<?php
include('dbinfo.php');





?>


<?php

include('dbinfo.php');
$alert = false;
if (isset($_POST['add'])) {
  $fname = $_POST['fname'];
  $email = $_POST['email'];
  $uname = $_POST['uname'];
  $pname = $_POST['pname'];
  $birth = $_POST['birth'];
  $gender = $_POST['gender'];
  $contact = $_POST['contact'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $currency = $_POST['currency'];

  $img = $_FILES['pic']['name'];
  $tpm_img = $_FILES['pic']['tmp_name'];
  $folder = 'assets/img/' . $img;
  move_uploaded_file($tpm_img, $folder);


  $pass = $_POST['pass'];
  $cpass = $_POST['cpass'];

  if ($pass == $cpass) {

    if (
      $fname != "" && $email != "" && $uname != "" && $pname != "" && $birth != "" && $gender != "" && $contact != "" && $city != ""
      && $country != "" && $pass != "" && $cpass != ""
    ) {

      $que = "INSERT INTO `user_signup`(`name`, `email`, `username`, `primary_name`, `birth`, `gender`, `contact`, `city`, `country`, `img`, `pasword`, `cpasword`, `preferred_currency`) values('$fname' , '$email' , '$uname'  , '$pname' , '$birth' , '$gender' , '$contact' , '$city' , '$country' ,'$img', '$pass' , '$cpass', '$currency')";

      $res = mysqli_query($con, $que);
      if ($res == true) {
        header('location:user_login.php');
      }

    }
  } else {
    $alert = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register -Student Management system</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- -======================================== -->

  <!-- font awsome link -->


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- -======================================== -->

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

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


  <style>
    :focus {
  outline: 0;
  border-color: #2260ff;
  box-shadow: 0 0 0 4px #b5c9fc;
}

.mydict div {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
 
}

.mydict input[type="radio"] {
  clip: rect(0 0 0 0);
  clip-path: inset(100%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}

.mydict input[type="radio"]:checked + span {
  box-shadow: 0 0 0 0.0625em #0043ed;
  background-color: #dee7ff;
  z-index: 1;
  color: #0043ed;
}

label span {
  display: block;
  cursor: pointer;
  background-color: #fff;
  padding: 0.375em .75em;
  position: relative;
  margin-left: .0625em;
  box-shadow: 0 0 0 0.0625em #b5bfd9;
  letter-spacing: .05em;
  color: #3e4963;
  text-align: center;
  transition: background-color .5s ease;
}

label:first-child span {
  border-radius: .375em 0 0 .375em;
}

label:last-child span {
  border-radius: 0 .375em .375em 0;
}

  </style>
</head>
<body>

  <?php
  if ($alert) {
    echo "<div class='alert alert-danger text-center' role='alert'>
  pelese chek passwrod & confrom_password it's not match
  </div>";
  }
  ?>



  <main style="width: 100%">
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <i style="color: #fd7e14; font-size: 22px;" class="fa-solid fa-plane"></i>
                  <span class="d-none d-lg-block text-dark" style="margin-left: 20px;">Expense Voyage</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3" style="width: 100%;">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 style="color: #fd7e14;" class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create an account</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                    <div class="col-6">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="fname" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email address!</div>
                    </div>

                    <div class="col-6">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="uname" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-6">
                      <label for="pname" class="form-label">Enter Your Primary School Name</label>
                      <input type="text" name="pname" class="form-control" id="pname" required>
                      <div class="invalid-feedback">Please type your primary school name!</div>
                    </div>

                    <div class="col-6">
                      <label for="pic" class="form-label">Select Photo</label>
                      <input type="file" name="pic" class="form-control" id="pic" required>
                      <div class="invalid-feedback">Please select a photo!</div>
                    </div>

                    <!-- ------------------------======================================================================= -->




                    <div class="col-6">
                    <label for="pic" class="form-label">Gender</label>
                      <div class="mydict">
                        <div>
                          <label>
                            <input type="radio" value="Men" name="gender" checked="">
                            <span>Men</span>
                          </label>
                          <label>
                            <input type="radio" value="Women" name="gender">
                            <span>Women</span>
                          </label>
                          <label>
                            <input type="radio" value="Others" name="gender">
                            <span>Divided</span>
                          </label>

                        </div>
                      </div>
                    </div>
                    <div class="col-6">
                      <label for="yourName" class="form-label">Country</label>
                      <input type="text" name="country" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your country Name!</div>
                    </div>


                    <div class="col-6">
                      <label for="yourName" class="form-label">City</label>
                      <input type="text" name="city" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your City Name!</div>
                    </div>
                    <div class="col-6">
                      <label for="yourName" class="form-label">Contact</label>
                      <input type="number" name="contact" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your country Name!</div>
                    </div>
                    <div class="col-6">
                      <label for="yourName" class="form-label">Date of birth</label>
                      <input type="date" name="birth" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your birth date</div>
                    </div>
                    <div class="col-6">
                    <label for="currency" class="form-label">Currency</label>
                      <div class="mydict">
                        <div>
                          <label>
                            <input type="radio" value="USD" name="currency">
                            <span>USD</span>
                          </label>
                          <label>
                            <input type="radio" value="PKR" name="currency" checked="">
                            <span>PKR</span>
                          </label>
                          <label>
                            <input type="radio" value="GBP" name="currency">
                            <span>GBP</span>
                          </label>
                          <label>
                            <input type="radio" value="EUR" name="currency">
                            <span>EUR</span>
                          </label>

                        </div>
                      </div>
                    </div>


                    <!-- ------------------------======================================================================= -->


                    <div class="col-6">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="pass" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-6">
                      <label for="confirmPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="cpass" class="form-control" id="confirmPassword" required>
                      <div class="invalid-feedback">Please enter your password again!</div>
                    </div>

                    <div class="col-12">
                      <button style="background-color: #fd7e14;" name="add" class="btn  w-100 text-light"
                        type="submit">Create Account</button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="user_login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main>


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

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