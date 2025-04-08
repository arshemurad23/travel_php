
<?php
session_start();

// Database connection
include('dbinfo.php'); // Ensure this file contains your database connection info

// Fetch data from the database
$query = "SELECT * FROM packages"; // Change 'tours' to your actual table name
$result = mysqli_query($con, $query);
?>


<?php
$destination_qur = "SELECT * FROM destination"; // Change 'tours' to your actual table name
$destination_res = mysqli_query($con, $destination_qur);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expense Voyage - Free Bootstrap 4 Template by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="user_login.php">Expense Voyage<span>Travel Agency</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="user_login.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">Destination</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">Hotel</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">Blog</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">Contact</a></li>
                    <li class="nav-item"><a href="user_sigup.php" class="nav-link">Sigin</a></li>
                    <li class="nav-item"><a href="user_login.php" class="nav-link">Login</a></li>

                </ul>
            </div>
        </div>
    </nav>

<!-- END nav -->
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<div class="hero-wrap js-fullheight" style="background-image: url('images/bg_5.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
            <div class="col-md-7 ftco-animate">
                <span class="subheading">Welcome to Expense Voyage</span>
                <h1 class="mb-4">Discover Your Favorite Place with Us</h1>
                <p class="caps">Travel to the any corner of the world, without going around in circles</p>
            </div>
            <a href="https://vimeo.com/45830194"
                class="icon-video popup-vimeo d-flex align-items-center justify-content-center mb-4">
                <span class="fa fa-play"></span>
            </a>
        </div>
    </div>
</div>

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


<section class="ftco-section services-section">
    <div class="container">
        <div class="row d-flex">
            <div class="col-md-6 order-md-last heading-section pl-md-5 ftco-animate d-flex align-items-center">
                <div class="w-100">
                    <span class="subheading">Welcome to Expense Voyage</span>
                    <h2 class="mb-4">It's time to start your adventure</h2>
                    <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It
                        is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics,
                        a large language ocean.
                        A small river named Duden flows by their place and supplies it with the necessary regelialia.
                    </p>
                    <p><a href="destination.php" class="btn btn-primary py-3 px-4">Search Destination</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-1 d-block img"
                            style="background-image: url(images/services-1.jpg);">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-paragliding"></span></div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Activities</h3>
                                <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-2 d-block img"
                            style="background-image: url(images/services-2.jpg);">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-route"></span></div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Travel Arrangements</h3>
                                <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-3 d-block img"
                            style="background-image: url(images/services-3.jpg);">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-tour-guide"></span></div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Private Guide</h3>
                                <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 d-flex align-self-stretch ftco-animate">
                        <div class="services services-1 color-4 d-block img"
                            style="background-image: url(images/services-4.jpg);">
                            <div class="icon d-flex align-items-center justify-content-center"><span
                                    class="flaticon-map"></span></div>
                            <div class="media-body">
                                <h3 class="heading mb-3">Location Manager</h3>
                                <p>A small river named Duden flows by their place and supplies it with the necessary</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section img ftco-select-destination" style="background-image: url(images/bg_3.jpg);">
<div class="container">
    <div class="row justify-content-center pb-4">
        <div class="col-md-12 heading-section text-center ftco-animate">
            <span class="subheading">Expense Voyage Provide Places</span>
            <h2 class="mb-4">Select Your Destination</h2>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="height: 400px; overflow-x: hidden;">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php while ($destination_row = mysqli_fetch_assoc($destination_res)) { ?>
                        <div class="swiper-slide">
                            <div class="project-destination" style="margin: 20px;">
                                <a href="#" class="img" style="background-image: url(assets/img/<?php echo $destination_row['img']; ?>)">
                                    <div class="text">
                                        <h3><?php echo $destination_row['country']; ?></h3>
                                        <span><?php echo $destination_row['tour']; ?> Tours</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Navigation -->
  
            </div>
        </div>
    </div>
</div>

<script>
    const swiper = new Swiper('.swiper-container', {
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>






</section>

<!-- Tour Destination -->

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading">Destination</span>
                <h2 class="mb-4">Tour Destination</h2>
            </div>
        </div>


        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4 ftco-animate">
                    <div class="project-wrap">
                        <a href="booking.php?id=<?php echo $row['id']; ?>" class="img"
                            style="background-size: cover; background-image: url(assets/img/<?php echo $row['img']; ?>)">
                            <span class="price"><?php echo   $row['price'] . '/person'; ?></span>
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
</section>
<!-- Tour Destination -->

<section class="ftco-section testimony-section bg-bottom" style="background-image: url(images/bg_1.jpg);">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
                <span class="subheading">Testimonial</span>
                <h2 class="mb-4">Tourist Feedback</h2>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel">
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="star">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </p>
                                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                    and Consonantia, there live the blind  texts.</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(images/person_1.jpg)"></div>
                                    <div class="pl-3">
                                        <p class="name">Roger Scott</p>
                                        <span class="position">Marketing Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="testimony-wrap py-4">
                            <div class="text">
                                <p class="star">
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                    <span class="fa fa-star"></span>
                                </p>
                                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia
                                    and Consonantia, there live the blind texts.</p>
                                <div class="d-flex align-items-center">
                                    <div class="user-img" style="background-image: url(images/person_2.jpg)"></div>
                                    <div class="pl-3">
                                        <p class="name">Roger Scott</p>
                                        <span class="position">Marketing Manager</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

include('footer.php');

?>