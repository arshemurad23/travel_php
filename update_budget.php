<?php
session_start();
include("dbinfo.php");
include("navber.php");

if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trip_id = $_POST['trip_id'];
    $total_budget = $_POST['total_budget'];
    $food_budget = $_POST['food_budget'];
    $flight_budget = $_POST['flight_budget'];
    $activities_budget = $_POST['activities_budget'];
    $hotel_budget = $_POST['hotel_budget'];

    $update_query = "UPDATE user_trips SET total_budget = ?, food_budget = ?, flight_budget = ?, activities_budget = ?, hotel_budget = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "dddddi", $total_budget, $food_budget, $flight_budget, $activities_budget, $hotel_budget, $trip_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location:budget_plan.php");
    exit();
}

$trip_id = $_GET['id'];
$trip_query = "SELECT * FROM user_trips WHERE id = ?";
$stmt = mysqli_prepare($con, $trip_query);
mysqli_stmt_bind_param($stmt, "i", $trip_id);
mysqli_stmt_execute($stmt);
$trip_result = mysqli_stmt_get_result($stmt);
$trip = mysqli_fetch_assoc($trip_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Budget</title>
    <link rel="stylesheet" href="assets/css/expense.css">
    <style>
        .alert.error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg'); height: 50vh;">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 50vh;">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Home <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span class="mr-2">
                            <a href="budget_plan.php">Budget <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span>Budget Update <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Budget Update</h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container" style="width: 70%;">
        <h2>Update Budget for <?php echo $trip['destination']; ?></h2>
        <form action="" method="POST" onsubmit="return validateBudget()">
            <input type="hidden" name="trip_id" value="<?php echo $trip['id']; ?>">
            <div class="form-group">
                <label for="total_budget">Total Budget</label>
                <input type="number" id="total_budget" name="total_budget" value="<?php echo $trip['total_budget']; ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="food_budget">Food Budget</label>
                <input type="number" id="food_budget" name="food_budget" value="<?php echo $trip['food_budget']; ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label for="flight_budget">Flight Budget</label>
                <input type="number" id="flight_budget" name="flight_budget"
                    value="<?php echo $trip['flight_budget']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="activities_budget">Activities Budget</label>
                <input type="number" id="activities_budget" name="activities_budget"
                    value="<?php echo $trip['activities_budget']; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hotel_budget">Hotel Budget</label>
                <input type="number" id="hotel_budget" name="hotel_budget" value="<?php echo $trip['hotel_budget']; ?>"
                    class="form-control" required>
            </div>

            <div id="warning" class="alert error" style="display:none; color:red;"></div>

            <button type="submit" class="submit-btn">Update Budget</button>
        </form>
    </div>
    <script>
        function validateBudget() {
            const totalBudget = parseFloat(document.getElementById("total_budget").value);
            const foodBudget = parseFloat(document.getElementById("food_budget").value);
            const flightBudget = parseFloat(document.getElementById("flight_budget").value);
            const activitiesBudget = parseFloat(document.getElementById("activities_budget").value);
            const hotelBudget = parseFloat(document.getElementById("hotel_budget").value);

            const totalSpent = foodBudget + flightBudget + activitiesBudget + hotelBudget;

            // Clear previous warnings
            document.getElementById("warning").style.display = "none";

            if (totalSpent > totalBudget) {
                const exceedAmount = totalSpent - totalBudget;
                document.getElementById("warning").innerText = "Warning: Your total expenses exceed your budget by $" + exceedAmount.toFixed(2) + ". Please adjust your expenses.";
                document.getElementById("warning").style.display = "block";
                return false; // Prevent form submission
            }

            return true; // Allow form submission
        }
    </script>

    <?php include("footer.php"); ?>
</body>

</html>