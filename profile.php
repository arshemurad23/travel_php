<?php
session_start();
if (!isset($_SESSION['name']) || $_SESSION['name'] != true) {
    header('location:user_login.php');
}
include("dbinfo.php");
include("navber.php");

// Fetch notifications for the logged-in user
$userId = $_SESSION['id'];
$stmt = $con->prepare("SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/profile.css?v=2">
    <title>User Profile</title>
    <style>
        /* Styles for the Hero Section */
        .hero-wrap {
            background-size: cover;
            background-position: center;
        }

        /* Popup Styles */
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            max-width: 600px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            z-index: 1000;
            padding: 20px;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .popup-content {
            padding: 20px;
        }

        .popup-close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .popup.show {
            display: block;
        }

        .popup-overlay.show {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <section class="hero-wrap hero-wrap-2" style="background-image: url('images/bg_1.jpg'); height: 50vh;">
        <div class="container">
            <div class="row no-gutters slider-text align-items-end justify-content-center" style="height: 50vh;">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="index.php">Home <i class="fa fa-chevron-right"></i></a>
                        </span>
                        <span>Profile <i class="fa fa-chevron-right"></i></span>
                    </p>
                    <h1 class="mb-0 bread">Profile</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-navbar">
            <a href="#" class="nav-btn" onclick="showPopup('notificationsPopup')">Notifications</a>
            <a href="#" class="nav-btn" onclick="showPopup('bookingPopup')">Trips</a>
            <a href="budget_plan.php" class="nav-btn">Budget Plan</a>
            <a href="update_profile.php" class="nav-btn">Edit Profile</a>
            <a href="logout.php" class="nav-btn">Logout</a>
        </div>

        <div class="profile-content">
            <div class="profile-image">
                <img src="assets/img/<?php echo $_SESSION['pic']; ?>" alt="Profile Picture">
            </div>
            <h2><?php echo $_SESSION['name']; ?></h2>
            <div class="contact-info">
                <p><?php echo $_SESSION['contact']; ?></p>
                <p><?php echo $_SESSION['country']; ?>, <?php echo $_SESSION['city']; ?></p>
            </div>
        </div>

        <div class="profile-info">
            <h2>Profile Information</h2>
            <ul>
                <li><span>Name:</span>
                    <p><?php echo $_SESSION['name']; ?></p>
                </li>
                <li><span>Email Address:</span>
                    <p><?php echo $_SESSION['email']; ?></p>
                </li>
                <li><span>Contact:</span>
                    <p><?php echo $_SESSION['contact']; ?></p>
                </li>
                <li><span>Date of Birth:</span>
                    <p><?php echo $_SESSION['birth']; ?></p>
                </li>
                <li><span>Gender:</span>
                    <p><?php echo $_SESSION['gender']; ?></p>
                </li>
                <li><span>City:</span>
                    <p><?php echo $_SESSION['city']; ?></p>
                </li>
                <li><span>Country:</span>
                    <p><?php echo $_SESSION['country']; ?></p>
                </li>
                <li><span>Preferred Currency:</span>
                    <p><?php echo $_SESSION['preferred_currency']; ?></p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Booking Popup -->
    <div id="bookingPopup" class="popup">
        <div class="popup-content">
            <span class="popup-close" onclick="closePopup('bookingPopup')">&times;</span>
            <h2>Your Bookings</h2>
            <a href="" id="export-btn" class="btn btn-secondary">Export to PDF</a> <!-- Export button -->
            <!-- Content for bookings will be fetched here -->
            <?php
            // Fetch user trips
            $user_id = $_SESSION['id'];
            $trips_query = "SELECT *, (total_budget - (food_budget + flight_budget + activities_budget + hotel_budget)) AS remaining_expense FROM user_trips WHERE user_id = ?";
            $stmt = mysqli_prepare($con, $trips_query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $trips_result = mysqli_stmt_get_result($stmt);

            ?>


            <table class="table" id="table-data">
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
    </div>

    <div id="notificationsPopup" class="popup">
        <div class="popup-content">
            <span class="popup-close" onclick="closePopup('notificationsPopup')">&times;</span>
            <h2>Notifications</h2>
            <div class="notification-list">
                <?php if (count($notifications) > 0): ?>
                    <ul>
                        <?php foreach ($notifications as $notification): ?>
                            <li>
                                <p><?php echo htmlspecialchars($notification['message']); ?></p>
                                <small><?php echo date('Y-m-d H:i:s', strtotime($notification['created_at'])); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No notifications found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div id="popupOverlay" class="popup-overlay"></div>

    <?php include("footer.php"); ?>

    <script>
        function showPopup(id) {
            document.getElementById(id).classList.add('show');
            document.getElementById('popupOverlay').classList.add('show');
        }

        function closePopup(id) {
            document.getElementById(id).classList.remove('show');
            document.getElementById('popupOverlay').classList.remove('show');
        }
    </script>
</body>

</html>