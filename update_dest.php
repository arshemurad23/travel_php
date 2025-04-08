<?php

include('dbinfo.php');

if (isset($_POST['add'])) {
    $tour_id = $_POST['tour_id'];
    $country = $_POST['country'];
    $tour = $_POST['tour'];

    // Get the current image from the database
    $currentImageQuery = "SELECT img FROM destination WHERE id = '$tour_id'";
    $currentImageResult = mysqli_query($con, $currentImageQuery);
    $currentImageRow = mysqli_fetch_assoc($currentImageResult);
    $currentImage = $currentImageRow['img'];

    // Check if a new image has been uploaded
    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
        $img = $_FILES['img']['name'];
        $tpm_img = $_FILES['img']['tmp_name'];
        $folder = 'assets/img/' . $img;

        // Move the new image to the desired folder
        move_uploaded_file($tpm_img, $folder);
    } else {
        // If no new image, retain the current image
        $img = $currentImage;
    }

    // Validate input fields
    if ($tour_id != "" && $country != "" && $tour != "") {
        $qur = "UPDATE destination SET country='$country', img='$img', tour='$tour' WHERE id='$tour_id'";
        $res = mysqli_query($con, $qur);

        if ($res) {
            header('location:dashboard.php');
        }
    }
}
?>
