<?php
session_start();
include("dbinfo.php");
include("navber.php");

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Planner</title>
    <link rel="stylesheet" href="assets/css/expense.css?v=3">
    <style>
        .budget-planner {
            max-width: 700px;
            margin: auto;
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
                        <span>Budget <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Plan Budget</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="container budget-planner">
        <h2 class="section-heading">Plan Your Budget</h2>

        <?php if (isset($error)): ?>
            <div class="alert error"><?php echo $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="budget-form">
            <div class="form-group">
                <label for="destination">Destination</label>
                <input type="text" name="destination" id="destination" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="travel_date">Travel Date</label>
                <input type="date" name="travel_date" id="travel_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="total_budget">Total Budget</label>
                <input type="number" name="total_budget" id="total_budget" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="country">Select Country</label>
                <select name="country" id="country" class="form-control" required>
                    <?php foreach ($countries as $country_name => $budgets): ?>
                        <option value="<?php echo $country_name; ?>">
                        
                        <?php echo $country_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="food_budget">Food Budget</label>
                <input type="number" name="food_budget" id="food_budget" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="flight_budget">Flight Budget</label>
                <input type="number" name="flight_budget" id="flight_budget" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="activities_budget">Activities Budget</label>
                <input type="number" name="activities_budget" id="activities_budget" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="hotel_budget">Hotel Budget</label>
                <input type="number" name="hotel_budget" id="hotel_budget" class="form-control" required>
            </div>

            <button type="submit" class="submit-btn">Submit Budget</button>
        </form>

        <h2 class="section-heading">Your Trips</h2>
        <a href="pdf.php" id="export-btn" class="btn btn-secondary">Export to PDF</a> <!-- Export button -->

        <table class="table mt-2" id="table-data">
            <thead>
                <tr>
                    <th>Destination</th>
                    <th>Travel Date</th>
                    <th>Total Budget</th>
                    <th>Remaining Expense</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($trip = mysqli_fetch_assoc($trips_result)): ?>
                    <tr>
                        <td><?php echo $trip['destination']; ?></td>
                        <td><?php echo $trip['travel_date']; ?></td>
                        <td><?php echo $trip['total_budget']; ?></td>
                        <td><?php echo $trip['remaining_expense']; ?></td>
                        <td>
                            <a href="update_budget.php?id=<?php echo $trip['id']; ?>" class="btn btn-primary">Update</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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

<?php include("footer.php"); ?>
</body>

</html>