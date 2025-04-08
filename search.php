<?php
include("dbinfo.php");

$destination = $_GET['destination'] ?? '';
$checkin_date = $_GET['checkin_date'] ?? '';
$checkout_date = $_GET['checkout_date'] ?? '';
$price_limit = $_GET['price_limit'] ?? '';

// Build the SQL query
$query = "SELECT * FROM packages WHERE 1=1";
$params = [];
$types = '';

// Check if destination is provided
if ($destination) {
    $query .= " AND name LIKE ?";
    $params[] = "%$destination%";
    $types .= 's'; // string type
}

// Check if price limit is provided
if ($price_limit) {
    $query .= " AND price <= ?";
    $params[] = $price_limit;
    $types .= 'd'; // double type for price
}

// Prepare and execute the statement
$stmt = $con->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Display the results -->
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Search Results</span>
                <h2 class="mb-4">Available Tours</h2>
            </div>
        </div>

        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 ftco-animate">
                        <div class="project-wrap">
                            <a href="booking.php?id=<?php echo $row['id']; ?>" class="img"
                               style="background-size: cover; background-image: url(assets/img/<?php echo $row['img']; ?>)">
                                <span class="price"><?php echo '$' . $row['price'] . '/person'; ?></span>
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
            <?php else: ?>
                <div class="col-md-12 ftco-animate text-center">
                    <p>No results found for your search.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>