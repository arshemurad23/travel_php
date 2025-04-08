<?php
session_start();
include("dbinfo.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Expense Voyage</title>



	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- -======================================== -->

	<!-- font awsome link -->


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
		integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- -======================================== -->



	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/animate.css">

	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="css/magnific-popup.css">

	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="css/jquery.timepicker.css">


	<link rel="stylesheet" href="css/flaticon.css">
	<link rel="stylesheet" href="css/style.css?v=2">
</head>

<body>
<?php
// Fetch predefined country budgets
$query = "SELECT * FROM countries";
$result = mysqli_query($con, $query);

$countries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $countries[$row['name']] = [
        'food' => $row['food'],
        'flight' => $row['flight'],
        'activities' => $row['activities'],
        'hotel' => $row['hotel']
    ];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['id']; // Assuming you store user ID in session
    $destination = $_POST['destination'];
    $travel_date = $_POST['travel_date'];
    $total_budget = $_POST['total_budget'];
    $food_budget = $_POST['food_budget'];
    $flight_budget = $_POST['flight_budget'];
    $activities_budget = $_POST['activities_budget'];
    $hotel_budget = $_POST['hotel_budget'];
    $country = $_POST['country'];

    $total_spent = $food_budget + $flight_budget + $activities_budget + $hotel_budget;
    $country_budgets = $countries[$country];

    // Validation logic
    if ($total_spent > $total_budget) {
        $error = "Your total budget is exceeded by $" . ($total_spent - $total_budget);
    } elseif ($food_budget < $country_budgets['food']) {
        $error = "Food budget must be at least $" . $country_budgets['food'] . " for $country.";
    } elseif ($flight_budget < $country_budgets['flight']) {
        $error = "Flight budget must be at least $" . $country_budgets['flight'] . " for $country.";
    } elseif ($activities_budget < $country_budgets['activities']) {
        $error = "Activities budget must be at least $" . $country_budgets['activities'] . " for $country.";
    } elseif ($hotel_budget < $country_budgets['hotel']) {
        $error = "Hotel budget must be at least $" . $country_budgets['hotel'] . " for $country.";
    } else {
        // Insert into user_trips table
        $insert_query = "INSERT INTO user_trips (user_id, destination, travel_date, total_budget, food_budget, flight_budget, activities_budget, hotel_budget) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "issddddd", $user_id, $destination, $travel_date, $total_budget, $food_budget, $flight_budget, $activities_budget, $hotel_budget);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $success = "Budget successfully defined for $destination on $travel_date!";
    }
}

// Fetch user trips
$user_id = $_SESSION['id'];
$trips_query = "SELECT *, (total_budget - (food_budget + flight_budget + activities_budget + hotel_budget)) AS remaining_expense FROM user_trips WHERE user_id = ?";
$stmt = mysqli_prepare($con, $trips_query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$trips_result = mysqli_stmt_get_result($stmt);



?>



   
    <div class="container budget-planner">

        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

       
        <h2  style="color: #fd7e14; " class="section-heading text-center display-2 mt-5" >Your Trips</h2>

        <table class="table mt-5" id="table-data">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Total Budget</th>
                    <th>Remaining Expense</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php while ($trip = mysqli_fetch_assoc($trips_result)): ?>
                    <tr>
                        <td><?php echo $trip['destination']; ?></td>
                        <td><?php echo $trip['travel_date']; ?></td>
                        <td><?php echo $trip['total_budget']; ?></td>
                        <td><?php echo $trip['remaining_expense']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

            <a href="profile.php" id="export-btn" class="btn btn-info">Back</a> <!-- Export button -->
        <a onclick="window.print()" id="export-btn" style="background-color: #fd7e14; " class="btn text-dark.">Print</a> 

    </div>
    <script>
        document.getElementById("export-btn").addEventListener("click", () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Get the table
            const element = document.getElementById("my-table");
            const rows = Array.from(element.querySelectorAll("tr"));

            // Add each row to the PDF
            rows.forEach((row, index) => {
                const cols = row.querySelectorAll("th, td");
                cols.forEach((col, colIndex) => {
                    const text = col.innerText;
                    doc.text(text, colIndex * 40, index * 10 + 10); // Adjust coordinates as necessary
                });
            });

            // Save the generated PDF
            doc.save("trip_budget_report.pdf");
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</body>

</html>
</div>


</body>

</html>