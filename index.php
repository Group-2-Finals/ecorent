<?php include("connect.php");
include("shared/classes/User.php");
include("shared/classes/Item.php");
include("shared/components/processIndex.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EcoRent | Homepage</title>
    <link rel="icon" type="image/png" href="shared/assets/img/system/ecorent-logo-2.png">

    <!-- STYLINGS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="shared/assets/css/style.css">
    <link rel="stylesheet" href="shared/assets/css/footerNav.css">

    <!-- FONTS -->
    <link rel="stylesheet" href="shared/assets/font/font.css">
</head>

<body id="homepage">
    <?php include 'shared/components/navbar.php'; ?>
    <!-- <div class="container my-3 p-4 rounded-5" id="carousel-container">
        <div class="row g-2">
            <div class="col-md-8">
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="shared/assets/img/system/caro1.png" class="d-block w-100" alt="Carousel Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="shared/assets/img/system/caro1.png" class="d-block w-100" alt="Carousel Image 2">
                        </div>
                        <div class="carousel-item">
                            <img src="shared/assets/img/system/caro1.png" class="d-block w-100" alt="Carousel Image 3">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex flex-column gap-2">
                <img src="shared/assets/img/system/static-image.png" class="w-100 rounded-5" alt="Static Image 1">
                <img src="shared/assets/img/system/static-image.png" class="w-100 rounded-5" alt="Static Image 2">
            </div>
        </div>
    </div> -->

    <section class="container my-3">
        <div class="row justify-content-between g-3">

            <a href="listings.php" class="col-12 col-sm-6 col-md-4 col-lg-auto">
                <div class="d-flex align-items-center p-3 rounded-pill" style="background-color: #343333;">
                    <img src="shared/assets/img/system/photography.png" class="img-fluid me-2"
                        style="width: 55px; height: auto;">
                    <h5 class="mb-0">Photography</h5>
                </div>
            </a>

            <a href="listings.php" class="col-12 col-sm-6 col-md-4 col-lg-auto">
                <div class="d-flex align-items-center p-3 rounded-pill" style="background-color: #343333;">
                    <img src="shared/assets/img/system/transportation.png" class="img-fluid me-2"
                        style="width: 55px; height: auto;">
                    <h5 class="mb-0">Transportation</h5>
                </div>
            </a>

            <a href="listings.php" class="col-12 col-sm-6 col-md-4 col-lg-2">
                <div class="d-flex align-items-center p-3 rounded-pill" style="background-color: #343333;">
                    <img src="shared/assets/img/system/clothing.png" class="img-fluid me-2"
                        style="width: 55px; height: auto;">
                    <h5 class="mb-0">Clothing</h5>
                </div>
            </a>

            <a href="listings.php" class="col-12 col-sm-6 col-md-6 col-lg-2">
                <div class="d-flex align-items-center p-3 rounded-pill" style="background-color: #343333;">
                    <img src="shared/assets/img/system/gadgets.png" class="img-fluid me-2"
                        style="width: 55px; height: auto;">
                    <h5 class="mb-0">Gadgets</h5>
                </div>
            </a>

            <a href="listings.php" class="col-12 col-sm-6 col-md-6 col-lg-2">
                <div class="d-flex align-items-center p-3 rounded-pill" style="background-color: #343333;">
                    <img src="shared/assets/img/system/outdoor.png" class="img-fluid me-2"
                        style="width: 55px; height: auto;">
                    <h5 class="mb-0">Outdoor</h5>
                </div>
            </a>
        </div>
    </section>

    <section>
        <div class="container my-3">
            <div class="row">
                <div class="col">
                    <div class="h2">
                        Just for you
                    </div>
                </div>
            </div>
            <div class="row" id="container">
            </div>

            <div class="text-center my-3">
                <button class="btn btn-dark">
                    SEE MORE
                </button>
            </div>
        </div>
    </section>
    <?php include 'shared/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="shared/assets/js/script.js"></script>
    <script src="shared/assets/js/script.js"></script>
    <script>
        var itemNames = ["TrailMaster X200 Mountain", "TrailMaster X200 Mountain", "TrailMaster X200 Mountain",
            "TrailMaster X200 Mountain", "TrailMaster X200 Mountain", "TrailMaster X200 Mountain",
            "TrailMaster X200 Mountain", "TrailMaster X200 Mountain"
        ];
        var pics = ["bike1.png", "bike1.png", "bike1.png", "bike1.png", "bike1.png", "bike1.png", "bike1.png", "bike1.png"];
        var prices = ["₱100", "₱100", "₱100", "₱100", "₱100", "₱100", "₱100", "₱100"];

        for (var i = 0; i < itemNames.length; i++) {
            var container = document.getElementById("container");
            container.innerHTML += `
        <a href="product-page.php" class="item-card col-12 col-md-6 col-lg-4 col-xl-3"><div>
            <div class="card my-3 custom-card" id="card${i}">
                <img src="shared/assets/img/system/${pics[i]}" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">${itemNames[i]}</h5>
                    <h5 class="card-text">Bike</h5>
                    <h5 class="card-text price">${prices[i]}</h5>
                </div>
            </div>
        </div></a>
    `;
        }
    </script>
</body>

</html>