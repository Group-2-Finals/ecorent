<?php
include("shared/processes/process-index.php");
include("connect.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoRent | Booking Page</title>
    <link rel="icon" type="image/png" href="shared/assets/img/system/ecorent-logo-2.png">

    <!-- STYLINGS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="shared/assets/css/style.css">
    <link rel="stylesheet" href="shared/assets/css/footerNav.css">
    <link rel="stylesheet" href="shared/assets/css/cart.css">

    <!-- FONTS -->
    <link rel="stylesheet" href="shared/assets/font/font.css">
</head>

<body id="cart-page">
    <?php include 'shared/components/navbar.php'; ?>

    <div class="container mt-5">

        <h1>
            <strong>
                My Cart
            </strong>
        </h1>

        <div class="row">
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col">
                        <div class="add-all-items mt-2 mb-2 px-4 py-2 rounded-4">
                            <div class="form-check d-flex justify-content-between">
                                <div class="d-flex mt-1">
                                    <input class="form-check-input check-custom" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <label class="form-check-label ms-4 form-check-label-custom" for="defaultCheck1">
                                        Select All Items
                                    </label>
                                </div>
                                <i class="bi bi-trash trash-custom"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="container cart-container mt-2 mb-2 px-3 py-3 rounded-4">
                            <div class="row p-2">
                                <div class="col-auto d-flex align-items-center">
                                    <input class="form-check-input me-4 check-custom" type="checkbox" value=""
                                        id="defaultCheck1">
                                    <img src="shared/assets/img/system/booking-page/bike 1.svg" class="rounded-2"
                                        style="width: 96px; height: auto;">
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <h4>
                                            TrailMaster X200 Mountain Bike
                                        </h4>
                                    </div>
                                    <div class="row row-loc">
                                        <div class="loc-custom">
                                            <i class="bi bi-geo-alt-fill loc-custom"></i>
                                            <span class="ms-1">Brgy. San Antonio, Sto.Tomas, Batangas</span>
                                        </div>
                                    </div>
                                    <div class="row pt-1">
                                        <div>
                                            <span class="badge rounded-pill pill-condition">Good Condition</span>
                                            <span class="badge rounded-pill pill-carbon-emission">-25 kg CO₂</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-auto d-flex ps-5">
                                    <h4 class="price-custom">
                                        ₱500
                                    </h4>
                                    <h4 class="per-day-custom">
                                        /day
                                    </h4>
                                </div>
                            </div>
                            <div class="row px-5">
                                <div class="col-auto d-flex justify-content-start me-5">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">Rental period:</p>
                                        <div class="cart-quantity-container d-flex align-items-center mx-2 my-2">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm btn-cart-subtract"
                                                onclick="decreaseRentalPeriod()">-</button>
                                            <input id="rentalPeriod" type="number" class="form-control text-center"
                                                name="rental-period" min="1" value="1" step="1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-cart-add "
                                                onclick="increaseRentalPeriod()">+</button>
                                        </div>
                                        <p class="mb-0">days</p>
                                    </div>
                                </div>
                                <div class="col-auto d-flex justify-content-start">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0">Quantity:</p>
                                        <div class="cart-quantity-container d-flex align-items-center mx-2 my-2">
                                            <button type="button"
                                                class="btn btn-outline-secondary btn-sm btn-cart-subtract"
                                                onclick="decreaseQuantity()">-</button>
                                            <input id="quantity" type="number" class="form-control text-center"
                                                name="quantity" min="1" value="1" step="1">
                                            <button type="button" class="btn btn-outline-secondary btn-sm btn-cart-add"
                                                onclick="increaseQuantity()">+</button>
                                        </div>
                                        <p class="mb-0">13 stocks available</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="container cart-container mt-2 mb-2 p-4 rounded-4">
                    <div class="row">
                        <div class="col">
                            <h5>
                                Booking Summary
                            </h5>
                            <p>
                                Estimated Price:
                            </p>
                            <h4 class="est-price">
                                <strong>
                                    ₱2000
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <button class="btn btn-checkout mt-2"><strong>
                                    Checkout Rentals
                                </strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="shared/assets/js/script.js"></script>
    <script>
        var rentalPeriod = document.getElementById('rentalPeriod');
        function increaseRentalPeriod() {
            rentalPeriod.stepUp();
        }
        function decreaseRentalPeriod() {
            rentalPeriod.stepDown();
        }

        var quantity = document.getElementById('quantity');
        function increaseQuantity() {
            quantity.stepUp();
        }
        function decreaseQuantity() {
            quantity.stepDown();
        }

        // DISABLE THE CARACTERS (ONLY NUMBERS)
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '');
            });
        });
    </script>
</body>

</html>