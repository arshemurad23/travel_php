
<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('location:admin_login.php');
    exit();
}


// Include database connection
include('dbinfo.php');


 // Query to get all destinations
 $booktQuery = "SELECT * FROM  bookings"; 
 $bookResult = mysqli_query($con, $booktQuery);
 $bookcount = mysqli_num_rows($bookResult);




 // Query to get all destinations
 $destQuery = "SELECT * FROM destination"; 
 $destResult = mysqli_query($con, $destQuery);
 $destcount = mysqli_num_rows($destResult);



// Replace this with the correct query for recent packages
$packagesQuery = "SELECT * FROM packages"; // Assuming you have a packages table
$packagesResult = mysqli_query($con, $packagesQuery);
if (!$packagesResult) {
    die('Query Failed: ' . mysqli_error($con));
}

$packages = mysqli_num_rows($packagesResult);


// Fetch user count
$userQuery = "SELECT * FROM user_signup";
$userResult = mysqli_query($con, $userQuery);
if (!$userResult) {
    die('Query Failed: ' . mysqli_error($con));
}
$count = mysqli_num_rows($userResult);

// Fetch packages (assuming you have a table named 'packages')
$packageQuery = "SELECT * FROM packages";
$packageResult = mysqli_query($con, $packageQuery);
if (!$packageResult) {
    die('Query Failed: ' . mysqli_error($con));
}
?>
<?php
include('dbinfo.php'); // Include your database connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the deletion query
    $deleteQuery = "DELETE FROM packages WHERE id = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the page with a success message
        header("Location: dashboard.php?message=Record deleted successfully");
        exit();
    } else {
        die("Error deleting record: " . mysqli_error($con));
    }
} else {
    echo "No ID specified.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


        

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
		integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



    <script>
        function searchPackages() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("packagesTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</head>

<body>
  
    <div class="sidebar bg-dark">
        <h2 class="text-white text-center mb-4">Travel Admin</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#packagesModal">Packages</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#destinationModal">Destination</a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#userModal">Users</a>
            </li>
  
            </li>
     
            <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#masgModal">Messages
</a>
</li>
            <li class="nav-item">
                <a type="button" class="nav-link" data-toggle="modal" data-target="#analyticsModal">
                    Analytics
                </a>

            </li>

            <li class="nav-item">
    <a class="nav-link" href="#" data-toggle="modal" data-target="#bookingsModal">Bookings</a>
</li>


            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
           
        </ul>
    </div>

    <div class="content">
        <div class="header">
            <h1>Dashboard</h1>

            <div class="d-flex align-items-center">
            <input type="text" id="searchInput" class="form-control" placeholder="Search..."
                    onkeyup="searchPackages()" style="width: 250px;">
              
                    <div class="dropdown ml-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i style="color: #fd7e14;" class="fas fa-user"></i> <?php echo $_SESSION['admin_name'] ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">


        <div class="col-md-3 widget">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Users</h5>
                        <h2 class="card-text"><?php echo $count ?></h2>
                    </div>
                </div>
            </div>


            <div class="col-md-3 widget">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total packages</h5>
                        <h2 class="card-text"><?php echo $packages ?></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 widget">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Total Destination</h5>
                        <h2 class="card-text"><?php echo $destcount ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3 widget">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Totale bookings</h5>
                        <h2 class="card-text"><?php echo  $bookcount ?></h2>
                    </div>
                </div>
            </div>

            


        </div>

        <div class="row mt-4">
    <div class="col-md-12">
        <h2>Recent Packages</h2>
        <div class="table-responsive">
            <table id="packagesTable" class="table table-striped">
                <thead>
                    <tr>
                        
                        <th>Name</th>
                        <th>Location</th>
                        <th>Day</th>
                        <th>Bedroom</th>
                        <th>Washroom</th>
                        <th>Country</th>
                        <th>Destination</th>
                        <th>Price</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($packagesrow = mysqli_fetch_array($packagesResult)) {
                    ?>
                    <tr>
                       
                        <td><?php echo $packagesrow['name']; ?></td>
                        <td><?php echo $packagesrow['location']; ?></td>
                        <td><?php echo $packagesrow['days']; ?></td>
                        <td><?php echo $packagesrow['bedroom']; ?></td>
                        <td><?php echo $packagesrow['washroom']; ?></td>
                        <td><?php echo $packagesrow['nearby']; ?></td>
                        <td><?php echo $packagesrow['description']; ?></td>
                        <td><?php echo $packagesrow['price']; ?></td>
                        <td>
                            <button class="btn btn-success" data-toggle="modal" data-target="#updateModal<?php echo $packagesrow['id']; ?>">
                                Update
                            </button>
                        </td>
                        <td>
                            <a href='dashboard.php?id=<?php echo $packagesrow['id']; ?>' class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Structure -->
                    <div class="modal fade" id="updateModal<?php echo $packagesrow['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $packagesrow['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalLabel<?php echo $packagesrow['id']; ?>">Update Item</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="packaging_update.php" enctype="multipart/form-data">
                                        <div class="mb-3 mt-3">
                                            <label for="ID">Package ID:</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($packagesrow['id']); ?>" name="id" readonly>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="ename">Package Name:</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($packagesrow['name']); ?>" name="ename" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="location">Location:</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($packagesrow['location']); ?>" name="location" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="days">Days:</label>
                                            <input type="number" class="form-control" value="<?php echo htmlspecialchars($packagesrow['days']); ?>" name="days" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="img">Image:</label>
                                            <input type="file" class="form-control" name="img">
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="bedroom">Bedroom:</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($packagesrow['bedroom']); ?>" name="bedroom" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="washroom">Washroom:</label>
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($packagesrow['washroom']); ?>" name="washroom" required>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="nearby">Nearby:</label>

                                            <select  class="form-control" value="<?php echo htmlspecialchars($packagesrow['nearby']); ?>" name="nearby"  required>
                                <option value="USA">USA</option>
                                <option value="Europe">Europe</option>
                                <option value="Germany">Germany</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>

                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" name="description" required><?php echo htmlspecialchars($packagesrow['description']); ?></textarea>
                                        </div>

                                        <div class="mb-3 mt-3">
                                            <label for="price">Price:</label>
                                            <input type="number" class="form-control" value="<?php echo htmlspecialchars($packagesrow['price']); ?>" name="price" required>
                                        </div>

                                        <button type="submit" name="add" class="btn btn-primary">Update Package</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




        <!-- ------------------------------------------------------------- -->



        <div class="row mt-5">
    <div class="col-md-12">
        <h2>Destination</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Country Name</th>
                    <th>Tour</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!$destResult) {
                    die('Query Failed: ' . mysqli_error($con));
                }

                while ($drow = mysqli_fetch_array($destResult)) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($drow['id']); ?></td>
                        <td><?php echo htmlspecialchars($drow['country']); ?></td>
                        <td><?php echo htmlspecialchars($drow['tour']); ?></td>
                        <td>
                            <button class="btn btn-success" data-toggle="modal" data-target="#settingsModal<?php echo $drow['id']; ?>">Update</button>
                        </td>
                       
                    
                    <!-- Settings Modal -->
                    <div class="modal fade" id="settingsModal<?php echo $drow['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="settingsModalLabel<?php echo $drow['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="settingsModalLabel<?php echo $drow['id']; ?>">Edit Settings for ID <?php echo htmlspecialchars($drow['id']); ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                        



                                    <form action="update_dest.php" class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate onsubmit="return validateForm()">

                        <div class="col-12 mt-3">
                            <label for="destinationTour" class="form-label">Tour</label>
                            <input type="text" value="<?php echo htmlspecialchars($drow['id']); ?>" name="tour_id" class="form-control" id="destinationTour" required>
                            <div class="invalid-feedback">Please enter the tour!</div>
                        </div>

                        <div class="col-12">
                            <label for="destinationName" class="form-label">Country Name</label>
                            <select name="country" class="form-control" id="destinationName" required>
                            <option value="USA">USA</option>
                                <option value="Europe">Europe</option>
                                <option value="Germany">Germany</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>

                            <div class="invalid-feedback">Please enter the destination name!</div>
                        </div>


                        <div class="col-12 mt-3">
                            <label for="destinationPhoto" class="form-label">Select photo</label>
                            <input type="file" name="img" value="<?php echo htmlspecialchars($drow['img']); ?>" class="form-control" id="destinationPhoto" required>
                            <div class="invalid-feedback">Please select a photo!</div>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="destinationTour" class="form-label">Tour</label>
                            <input type="number" value="<?php echo htmlspecialchars($drow['tour']); ?>" name="tour" class="form-control" id="destinationTour" required>
                            <div class="invalid-feedback">Please enter the tour!</div>
                        </div>

                        <div class="col-12 mt-3">
                            <button style="background-color: #fd7e14;" name="add" class="btn w-100 text-light"
                                type="submit">Update</button>
                        </div>

                    </form>












                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <td><a href='dlt_desg.php?id=<?php echo $drow['id']; ?>' class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                                </td>
                                </tr>


                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>





                    </tbody>
                </table>
            </div>
        </div>






        <footer>
            <p>&copy; 2024 Travel Admin Dashboard. All rights reserved.</p>
        </footer>
    </div>




<!--                                              START MODAL =============================================================================================================================== -->



    <!-- Analytics Modal -->
    <div class="modal fade" id="analyticsModal" tabindex="-1" role="dialog" aria-labelledby="analyticsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="analyticsModalLabel">Analytics Overview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Total Packages: <?php echo $packages ?></h4>
                    <h4>Total Users: <?php echo $count; ?></h4>
                    <h4>Revenue: $50,000</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($userResult)) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><a href="delete_user.php?id=<?php echo $row['id']; ?>"><span
                                                class="badge badge-danger">Delete</span></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Packages Modal -->
    <div class="modal fade" id="packagesModal" tabindex="-1" role="dialog" aria-labelledby="packagesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="packagesModalLabel">Packages List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_package.php" class="row g-3 needs-validation" method="post"
                        enctype="multipart/form-data" novalidate>
                        <div class="col-4">
                            <label for="packageName" class="form-label">Package Name</label>
                            <input type="text" name="name" class="form-control" id="packageName" required>
                            <div class="invalid-feedback">Please enter Package Name!</div>
                        </div>

                        <div class="col-4">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required>
                            <div class="invalid-feedback">Please enter Location!</div>
                        </div>

                        <div class="col-4">
                            <label for="days" class="form-label">Days</label>
                            <input type="number" name="days" class="form-control" required>
                            <div class="invalid-feedback">Please enter Days!</div>
                        </div>

                        <div class="col-6 mt-3">
                            <label for="pic" class="form-label">Select Photo</label>
                            <input type="file" name="pic" class="form-control" id="pic" required>
                            <div class="invalid-feedback">Please select a photo!</div>
                        </div>

                        <div class="col-6 mt-3">
                            <label for="bedroom" class="form-label">Enter Bedroom</label>
                            <input type="text" name="bedroom" class="form-control" id="bedroom" required>
                            <div class="invalid-feedback">Please type Bedroom!</div>
                        </div>

                        <div class="col-6 mt-3">
                            <label for="washroom" class="form-label">Enter Washroom</label>
                            <input type="text" name="washroom" class="form-control" id="washroom" required>
                            <div class="invalid-feedback">Please enter Washroom!</div>
                        </div>

                        <div class="col-6 mt-3">
                            <label for="nearby" class="form-label">country</label>
                            <select name="nearby" class="form-control" id="destinationName" required>
                                <option value="USA">USA</option>
                                <option value="France">Europe</option>
                                <option value="Canada">Germany</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>
                            <div class="invalid-feedback">Please enter Nearby!</div>
                        </div>

                        <div class="col-6 mt-2">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="descrip" class="form-control" required>
                            <div class="invalid-feedback">Please enter the Description!</div>
                        </div>

                        <div class="col-6 mt-2">
                            <label for="price" class="form-label">Fix Price</label>
                            <input type="number" name="price" class="form-control" required>
                            <div class="invalid-feedback">Please enter Price!</div>
                        </div>

                        <div class="col-6 mt-3">
                            <button style="background-color: #fd7e14;" name="add" class="btn w-100 text-light"
                                type="submit">Create Package</button>
                        </div>
                    </form>
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            const form = document.querySelector("form");

                            form.addEventListener("submit", function (event) {
                                let valid = true;

                                // Check all required inputs
                                const inputs = form.querySelectorAll("[required]");
                                inputs.forEach(input => {
                                    if (!input.value) {
                                        valid = false;
                                        input.classList.add("is-invalid");
                                    } else {
                                        input.classList.remove("is-invalid");
                                    }
                                });

                                if (!valid) {
                                    event.preventDefault(); // Prevent form submission
                                    alert("Please fill in all required fields."); // Custom error message
                                }
                            });
                        });
                    </script>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ==================================================================== -->
    <!-- Destination Modal -->





    <div class="modal fade" id="destinationModal" tabindex="-1" role="dialog" aria-labelledby="destinationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destinationModalLabel">Add Destination</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_destination.php" class="row g-3 needs-validation" method="post"
                        enctype="multipart/form-data" novalidate onsubmit="return validateForm()">

                        <div class="col-12">
                            <label for="destinationName" class="form-label">Country Name</label>
                            <select name="country" class="form-control" id="destinationName" required>
                            <option value="USA">USA</option>
                                <option value="Europe">Europe</option>
                                <option value="Germany">Germany</option>
                                <option value="Pakistan">Pakistan</option>
                            </select>

                            <div class="invalid-feedback">Please enter the destination name!</div>
                        </div>






                        <div class="col-12 mt-3">
                            <label for="destinationPhoto" class="form-label">Select photo</label>
                            <input type="file" name="pic" class="form-control" id="destinationPhoto" required>
                            <div class="invalid-feedback">Please select a photo!</div>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="destinationTour" class="form-label">Tour</label>
                            <input type="number" name="tour" class="form-control" id="destinationTour" required>
                            <div class="invalid-feedback">Please enter the tour!</div>
                        </div>

                        <div class="col-12 mt-3">
                            <button style="background-color: #fd7e14;" name="add" class="btn w-100 text-light"
                                type="submit">Add Destination</button>
                        </div>

                    </form>

                    <script>
                        function validateForm() {
                            const country = document.getElementById('destinationName').value.trim();
                            const tour = document.getElementById('destinationTour').value.trim();

                            if (!country) {
                                alert('Please enter the destination name!');
                                return false;
                            }

                            if (!tour) {
                                alert('Please enter the tour!');
                                return false;
                            }

                            return true; // Allow form submission
                        }
                    </script>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ======--------------------------------------------------------============================================= -->
<!-- masg modal -->
<!-- The Modal -->
<style>#masgModal .modal-dialog {
    max-width: 80%; /* Yahan apni desired width set karein */
}
</style>
<?php

$messages_qur = "select * from messages " ;
$messages_res = mysqli_query($con,$messages_qur);
?>
<div class="modal fade" id="masgModal" tabindex="-1" role="dialog" aria-labelledby="masgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="masgModalLabel">Masg Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Messages</th>
                            <th>Date-time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($masgrow = mysqli_fetch_array($messages_res)) { ?>
                            <tr>
                                <td><?php echo $masgrow['id']; ?></td>
                                <td><?php echo $masgrow['name']; ?></td>
                                <td><?php echo $masgrow['email']; ?></td>
                                <td><?php echo $masgrow['subject']; ?></td>
                                <td><?php echo $masgrow['message']; ?></td>
                                <td><?php echo $masgrow['created_at']; ?></td>
                               
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- ---------------------------------------==================================================================== -->

<!-- Modal Structure -->
<div class="modal fade" id="bookingsModal" tabindex="-1" role="dialog" aria-labelledby="bookingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg custom-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingsModalLabel">Bookings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="packagesTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Package Name</th>
                            <th>Total Person</th>
                            <th>Total Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Create Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($bookrow = mysqli_fetch_array($bookResult)) {
                            // Fetch the package name based on package_id from bookings
                            $packeQuery = "SELECT name FROM packages WHERE id = '" . $bookrow['package_id'] . "'"; 
                            $packeResult = mysqli_query($con, $packeQuery);
                            $packageName = '';
                            
                            if ($packeRow = mysqli_fetch_array($packeResult)) {
                                $packageName = $packeRow['name'];
                            }
                        ?>

                        <tr>
                            <td><?php echo $bookrow['id']; ?></td>
                            <td><?php echo $bookrow['name']; ?></td>
                            <td><?php echo $bookrow['email']; ?></td>
                            <td><?php echo htmlspecialchars($packageName); ?></td> <!-- Correctly display package name -->
                            <td><?php echo $bookrow['number_of_people']; ?></td>
                            <td><?php echo $bookrow['total_price']; ?></td>
                            <td><?php echo $bookrow['start_date']; ?></td>
                            <td><?php echo $bookrow['end_date']; ?></td>
                            <td><?php echo $bookrow['created_at']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS to Increase Modal Width -->
<style>
    .custom-modal {
        max-width: 80%; /* Adjust the max width as needed */
    }
</style>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
























































</html>