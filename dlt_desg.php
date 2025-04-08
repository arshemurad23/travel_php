<?php
include('dbinfo.php');

// Fetch the ID from the request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete query
    $deleteQuery = "DELETE FROM destination WHERE id = ?";
    $deleteStmt = $con->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $id);

    if ($deleteStmt->execute()) {
        // Redirect after successful deletion
        header("Location: dashboard.php"); // Change to your relevant page
        exit;
    } else {
        echo "<div class='alert alert-danger'>Error deleting record: " . htmlspecialchars($con->error) . "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>No ID provided for deletion.</div>";
}
?>