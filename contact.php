<?php
session_start();
include('navber.php');

include('dbinfo.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $con->real_escape_string($_POST['name']);
  $email = $con->real_escape_string($_POST['email']);
  $subject = $con->real_escape_string($_POST['subject']);
  $message = $con->real_escape_string($_POST['message']);

  $sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  if ($con->query($sql) === TRUE) {
    echo "<script>alert('Message sent successfully!');</script>";
  } else {
    echo "<script>alert('Error: " . $sql . "<br>" . $con->error . "');</script>";
  }
}
?>

<!-- Your existing HTML code follows -->

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_1.jpg');">
  <div class="overlay"></div>
  <div class="container">
    <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
      <div class="col-md-9 ftco-animate pb-5 text-center">
        <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                class="fa fa-chevron-right"></i></a></span> <span>Contact us <i class="fa fa-chevron-right"></i></span>
        </p>
        <h1 class="mb-0 bread">Contact us</h1>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-no-pb contact-section mb-4">
  <div class="container">
    <div class="row d-flex contact-info">
      <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
          <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-map-marker"></span>
          </div>
          <h3 class="mb-2">Address</h3>
          <p>198 West 21th Street, Suite 721 New York NY 10016</p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
          <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-phone"></span>
          </div>
          <h3 class="mb-2">Contact Number</h3>
          <p><a href="tel://1234567920">+ 1235 2355 98</a></p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
          <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-paper-plane"></span>
          </div>
          <h3 class="mb-2">Email Address</h3>
          <p><a href="mailto:info@yoursite.com">info@yoursite.com</a></p>
        </div>
      </div>
      <div class="col-md-3 d-flex">
        <div class="align-self-stretch box p-4 text-center">
          <div class="icon d-flex align-items-center justify-content-center">
            <span class="fa fa-globe"></span>
          </div>
          <h3 class="mb-2">Website</h3>
          <p><a href="#">yoursite.com</a></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section contact-section ftco-no-pt">
  <div class="container">
    <div class="row block-9">
      <div class="col-md-6 order-md-last d-flex">
        <form action="" method="POST" class="bg-light p-5 contact-form">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="form-group">
            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
          </div>
          <div class="form-group">
            <textarea name="message" cols="30" rows="7" class="form-control" placeholder="Message" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
          </div>
        </form>
      </div>
      <div class="col-md-6 d-flex">
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093365!2d144.9537363153162!3d-37.81720997975133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11cb39%3A0x5045675218cd8e0!2sYour%20Location!5e0!3m2!1sen!2sus!4v1600000000000!5m2!1sen!2sus"
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
include('footer.php');
?>