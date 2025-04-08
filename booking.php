<?php
session_start();
include("dbinfo.php");
include("navber.php");

// Fetch project details based on ID from the URL
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$stmt = $con->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle booking confirmation logic here
    $numberOfPeople = $_POST['number_of_people'];
    $totalPrice = $_POST['total_price'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Assuming name and email are stored in the session
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $userId = $_SESSION['id']; // Make sure user_id is stored in the session

    // Save the booking to the database
    $stmt = $con->prepare("INSERT INTO bookings (package_id, name, email, number_of_people, total_price, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $id, $name, $email, $numberOfPeople, $totalPrice, $startDate, $endDate);

    // Execute the statement
    if ($stmt->execute()) {
        // Assuming the booking is confirmed and you have $userId and $message
        $message = "Booking confirmed for {$project['name']}!";
        $stmt = $con->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $message);
        $stmt->execute();

        echo "<script>
                alert('Booking Confirmed! Thank you for your booking for {$project['name']} for $numberOfPeople person(s). Total Price: $_SESSION[preferred_currency]. $totalPrice');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Booking failed: " . $stmt->error . "');
              </script>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/booking.css">
    <title>Booking - <?php echo $project['name']; ?></title>
    <style>
        .booking-container {
            display: flex;
            /* Use flexbox for layout */
            max-width: 600px;
            /* Set a maximum width for the container */
            margin: 20px auto;
            /* Center the container */
            border: 1px solid #ccc;
            /* Optional: Add a border for visual separation */
            border-radius: 8px;
            /* Rounded corners */
            overflow: hidden;
            /* Hide overflow */
        }

        .image-container {
            flex: 1;
            /* Make the image container take up available space */
            width: 100%;
            /* Limit the width of the image */
        }

        .image-container img {
            width: 100%;
            /* Make the image responsive */
            height: auto;
            /* Maintain aspect ratio */
        }

        .details-container {
            flex: 2;
            /* Adjust the details container to take more space */
            padding: 20px;
            /* Add padding around the content */
            background-color: #f9f9f9;
            /* Light background for contrast */
        }

        /* Optional: Add some margin to form elements for better spacing */
        input,
        textarea,
        button {
            margin-bottom: 10px;
        }
    </style>
    <script>
        function updateTotalPrice() {
            const pricePerPerson = <?php echo $project['price']; ?>;
            const numberOfPeople = document.getElementById('number_of_people').value;
            const totalPrice = pricePerPerson * numberOfPeople;
            document.getElementById('total_price').value = totalPrice.toFixed(2);
            document.getElementById('total_display').textContent = totalPrice.toFixed(2);
        }
    </script>
</head>

<body>
    <section class="hero-wrap hero-wrap-2 js-fullheight"
        style="background-image: url('images/bg_1.jpg'); hieght: 50vh;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                    class="fa fa-chevron-right"></i></a></span> <span>Booking <i
                                class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Booking</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="booking-container">
            <img src="assets/img/<?php echo $project['img']; ?>" alt="<?php echo $project['name']; ?>" style=" height:300px; width:100%; ">


        <div class="details-container">
            <h1><?php echo $project['name']; ?></h1>
            <p><?php echo $project['description']; ?></p>
            <p class="price"><?php echo $_SESSION['preferred_currency'] . $project['price'] . '/person'; ?></p>

            <form method="POST">
                <label for="number_of_people">Number of People</label>
                <input type="number" id="number_of_people" name="number_of_people" placeholder="Number of People"
                    min="1" value="1" oninput="updateTotalPrice()" required>

                <input type="hidden" id="total_price" name="total_price" value="<?php echo $project['price']; ?>">
                <p>Total Price: <?php echo $_SESSION['preferred_currency']; ?><span id="total_display"><?php  echo $project['price']; ?></span></p>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="special_requests">Special Requests (optional):</label>
                <textarea id="special_requests" name="special_requests" rows="4"
                    placeholder="Any special requests or preferences?"></textarea>

                <button type="submit">Confirm Booking</button>
            </form>
        </div>
    </div>


    <?php include("footer.php"); ?>

    <script>
        updateTotalPrice();
    </script>
</body>

</html>