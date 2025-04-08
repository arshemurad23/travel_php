<?php
session_start();
if (!isset($_SESSION['name']) || $_SESSION['name'] != true) {
    header('location:user_login.php');
}

// Include database connection
include("dbinfo.php");
include("navber.php");

// Update profile logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $birth = $_POST['birth'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $user_id = $_SESSION['id']; // Assuming you have a user_id stored in the session
    $preferred_currency = $_POST['preferred_currency'];

    // Initialize $name_pic with existing image
    $name_pic = $_SESSION['pic'];

    // Handle file upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $uploads_dir = 'assets/img/';
        $tmp_name = $_FILES['profile_pic']['tmp_name'];
        $name_pic = basename($_FILES['profile_pic']['name']);
        move_uploaded_file($tmp_name, "$uploads_dir/$name_pic");

        // Update the profile picture path in the session
        $_SESSION['pic'] = $name_pic; // Update session variable to new image
    }

    // Update session variables
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['contact'] = $contact;
    $_SESSION['birth'] = $birth;
    $_SESSION['gender'] = $gender;
    $_SESSION['city'] = $city;
    $_SESSION['country'] = $country;
    $_SESSION['preferred_currency'] = $preferred_currency;

    // Update the database
    $stmt = $con->prepare("UPDATE user_signup SET name=?, email=?, contact=?, birth=?, gender=?, city=?, country=?, img=?, preferred_currency=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $name, $email, $contact, $birth, $gender, $city, $country, $name_pic, $preferred_currency, $user_id);

    if ($stmt->execute()) {
        // Redirect to profile page after successful update
        header('Location: profile.php');
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/profile.css">
  <title>Edit Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      color: #333;
    }

    .update-container {
      max-width: 600px;
      margin: 40px auto;
      padding: 15px;
      /* Reduced padding */
      border: 1px solid #e7e7e7;
      border-radius: 8px;
      background-color: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .update-container h2 {
      text-align: center;
      color: #ff6f20;
    }

    .update-container label {
      display: block;
      margin: 10px 0 5px;
      /* Reduced margin */
      font-weight: bold;
    }

    .update-container input,
    .update-container select {
      width: 100%;
      padding: 8px;
      /* Reduced padding */
      margin-bottom: 10px;
      /* Reduced margin */
      border: 1px solid #ccc;
      border-radius: 5px;
      transition: border-color 0.3s;
    }

    .update-container button {
      width: 100%;
      padding: 8px;
      /* Reduced padding */
      background-color: #ff6f20;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 16px;
    }

    .update-container button:hover {
      background-color: #e65c1f;
    }

    .update-container input[type="file"] {
      border: 1px solid #ccc;
    }

    .update-container input[type="file"]:focus {
      outline: none;
    }

    /* Responsive styles */
    @media (max-width: 600px) {
      .update-container {
        padding: 15px;
        margin: 20px;
      }

      .update-container h2 {
        font-size: 24px;
      }

      .update-container label {
        margin: 10px 0 5px;
      }

      .update-container input,
      .update-container select {
        padding: 8px;
      }

      .update-container button {
        padding: 8px;
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg'); height: 50vh;">
    <div class="container">
      <div class="row no-gutters slider-text align-items-end justify-content-center" style="height: 50vh;">
        <div class="col-md-9 ftco-animate pb-5 text-center">
          <p class="breadcrumbs">
            <span class="mr-2">
              <a href="index.php">Home <i class="fa fa-chevron-right"></i></a>
            </span>
            <span class="mr-2">
              <a href="profile.php">Profile <i class="fa fa-chevron-right"></i></a>
            </span>
            <span>Edit<i class="fa fa-chevron-right"></i></span>
          </p>
          <h1 class="mb-0 bread">Edit Profile</h1>
        </div>
      </div>
    </div>
  </section>
  <div class="update-container">
    <h2>Edit Profile</h2>
    <form method="POST" action="" enctype="multipart/form-data">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>

      <label for="contact">Contact:</label>
      <input type="text" id="contact" name="contact" value="<?php echo $_SESSION['contact']; ?>" required>

      <label for="birth">Date of Birth:</label>
      <input type="date" id="birth" name="birth" value="<?php echo $_SESSION['birth']; ?>" required>

      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="Male" <?php echo ($_SESSION['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo ($_SESSION['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        <option value="Other" <?php echo ($_SESSION['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
      </select>

      <label for="city">City:</label>
      <input type="text" id="city" name="city" value="<?php echo $_SESSION['city']; ?>" required>

      <label for="country">Country:</label>
      <input type="text" id="country"  name="country" value="<?php echo $_SESSION['country']; ?>" required>

      <label for="profile_pic">Profile Picture:</label>
      <input type="file" id="profile_pic" value="<?php echo $_SESSION['pic']; ?>" name="profile_pic" >

      <label for="preferred_currency">Preferred Currency:</label>
      <select id="preferred_currency" name="preferred_currency" required>
        <option value="USD" <?php echo ($_SESSION['preferred_currency'] == 'USD') ? 'selected' : ''; ?>>USD</option>
        <option value="EUR" <?php echo ($_SESSION['preferred_currency'] == 'EUR') ? 'selected' : ''; ?>>EUR</option>
        <option value="GBP" <?php echo ($_SESSION['preferred_currency'] == 'GBP') ? 'selected' : ''; ?>>GBP</option>
        <option value="PKR" <?php echo ($_SESSION['preferred_currency'] == 'PKR') ? 'selected' : ''; ?>>PKR</option>
      </select>



      <button type="submit">Update</button>
    </form>
  </div>
  <?php include("footer.php") ?>

</body>

</html>