<?php

include('dbinfo.php');

if (isset($_POST['add'])) {
    $packagesid = $_POST['id'];
    $packagesname = $_POST['ename'];
    $location = $_POST['location'];
    $days = $_POST['days'];
    $bedroom = $_POST['bedroom'];
    $washroom = $_POST['washroom'];
    $nearby = $_POST['nearby'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Get the current image from the database
    $currentImageQuery = "SELECT img FROM packages WHERE id = '$packagesid'";
    $currentImageResult = mysqli_query($con, $currentImageQuery);
    $currentImageRow = mysqli_fetch_assoc($currentImageResult);
    $currentImage = $currentImageRow['img'];

    // Initialize img with the current image
    $img = $currentImage;

    // Check if a new image has been uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
        $img = $_FILES['img']['name'];
        $tpm_img = $_FILES['img']['tmp_name'];
        $folder = 'assets/img/' . basename($img); // Use basename for security

        // Move the new image to the desired folder
        if (!move_uploaded_file($tpm_img, $folder)) {
            die("Error uploading file.");
        }
    }

    // Validate input fields
    if (!empty($packagesname) && !empty($location) && !empty($days) && !empty($bedroom) && !empty($washroom) && !empty($nearby) && !empty($description) && !empty($price)) {
        $qur = "UPDATE packages SET name='$packagesname', location='$location', days='$days', img='$img', bedroom='$bedroom', washroom='$washroom', nearby='$nearby', description='$description', price='$price' WHERE id = '$packagesid'";

        $res = mysqli_query($con, $qur);
        if ($res) {
            header('Location: dashboard.php');
            exit(); // Always exit after a redirect
        } else {
            die("Error updating record: " . mysqli_error($con));
        }
    } else {
        die("Please fill all fields.");
    }
}
?>
