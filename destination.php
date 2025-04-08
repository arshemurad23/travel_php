
<?php
session_start();
if (!isset($_SESSION['name']) || $_SESSION['name'] != true) {
	header('location:user_login.php');
}
?>




<?php
// Database connection
include('dbinfo.php'); // Ensure this file contains your database connection info
include("navber.php");

// Handle form submission
$destination = '';
$price_limit = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destination = mysqli_real_escape_string($con, $_POST['destination']);
    $price_limit = (int) $_POST['price_limit']; // Cast to integer for safety

    // Build the SQL query with filtering
    $query = "SELECT * FROM packages WHERE 1=1"; // Start with a base query

    if (!empty($destination)) {
        $query .= " AND name LIKE '%$destination%'"; // Assuming 'name' is the column for the tour name
    }
    if ($price_limit > 0) {
        $query .= " AND price <= $price_limit"; // Assuming 'price' is the column for the price
    }
} else {
    // Default query if no filter is applied
    $query = "SELECT * FROM packages";
}

// Execute the query
$result = mysqli_query($con, $query);


$destination_qur = "SELECT * FROM destination"; // Change 'tours' to your actual table name
$destination_res = mysqli_query($con, $destination_qur);




?>




<!-- END nav -->

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_1.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                class="fa fa-chevron-right"></i></a></span> <span>Tour List <i
                            class="fa fa-chevron-right"></i></span></p>
                <h1 class="mb-0 bread">Tours List</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="search-wrap-1 ftco-animate">
                    <form action="" method="POST" class="search-property-1">
                        <div class="row no-gutters">
                            <div class="col-lg d-flex">
                                <div class="form-group p-4 border-0">
                                    <label for="#">Destination</label>
                                    <div class="form-field">
                                        <div class="icon"><span class="fa fa-search"></span></div>
                                        <input type="text" name="destination" class="form-control"
                                            placeholder="Search place">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg d-flex">
                                <div class="form-group p-4">
                                    <label for="#">Price Limit</label>
                                    <div class="form-field">
                                        <div class="select-wrap">
                                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                                            <select name="price_limit" class="form-control">
                                                <option value="">Select Price Limit</option>
                                                <option value="5000">$5,000</option>
                                                <option value="10000">$10,000</option>
                                                <option value="50000">$50,000</option>
                                                <option value="100000">$100,000</option>
                                                <option value="200000">$200,000</option>
                                                <option value="300000">$300,000</option>
                                                <option value="400000">$400,000</option>
                                                <option value="500000">$500,000</option>
                                                <option value="1000000">$1,000,000</option>
                                                <option value="2000000">$2,000,000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg d-flex">
                                <div class="form-group d-flex w-100 border-0">
                                    <div class="form-field w-100 align-items-center d-flex">
                                        <input type="submit" value="Search"
                                            class="align-self-stretch form-control btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
    <?php
		function convertCurrency($amount, $fromCurrency, $toCurrency) {
    // Sample conversion rates (fetch from an API for production)
    $conversionRates = [
        'USD' => 1.0, // Base currency
        'EUR' => 0.85,
        'GBP' => 0.75,
        'PKR' => 160, // Example rate
        // Add more currencies as needed
    ];

    if (!isset($conversionRates[$fromCurrency]) || !isset($conversionRates[$toCurrency])) {
        return $amount; // Return original amount if currencies are not in the rates
    }

    // Convert to USD first, then to the desired currency
    $amountInUSD = $amount / $conversionRates[$fromCurrency];
    return round($amountInUSD * $conversionRates[$toCurrency], 2);
}
?>

		<div class="row">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-md-4 ftco-animate">
            <div class="project-wrap">
                <a href="booking.php?id=<?php echo $row['id']; ?>" class="img"
                    style="background-size: cover; background-image: url(assets/img/<?php echo $row['img']; ?>)">
                    <?php
                    // Assuming the original currency is USD
                    $originalCurrency = 'USD';
                    $preferredCurrency = $_SESSION['preferred_currency'];
                    $convertedPrice = convertCurrency($row['price'], $originalCurrency, $preferredCurrency);
                    ?>
                    <span class="price"><?php echo $preferredCurrency . ' ' . $convertedPrice . '/person'; ?></span>
                </a>
                <div class="text p-4">
                    <span class="days"><?php echo $row['days']; ?> Tour</span>
                    <h3><a href="booking.php?id=<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></h3>
                    <p class="location"><span class="fa fa-map-marker"></span> <?php echo $row['location']; ?></p>
                    <ul>
                        <li><span class="flaticon-shower"></span><?php echo $row['washroom']; ?></li>
                        <li><span class="flaticon-king-size"></span><?php echo $row['bedroom']; ?></li>
                        <li><span class="flaticon-mountains"></span><?php echo $row['nearby']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

    </div>
    <div class="row mt-5">
        <div class="col text-center">
            <div class="block-27">
                <ul>
                    <li><a href="#">&lt;</a></li>
                    <li class="active"><span>1</span></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&gt;</a></li>
                </ul>
            </div>
        </div>
    </div>
    </div>
</section>



<section class="ftco-intro ftco-section ftco-no-pt">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div class="img" style="background-image: url(images/bg_2.jpg);">
                    <div class="overlay"></div>
                    <h2>We Are Expense Voyage A Travel Agency</h2>
                    <p>We can manage your dream building A small river named Duden flows by their place</p>
                    <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Ask For A Quote</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

include('footer.php');

?>