<?php
include("shared/processes/process-index.php");
include("connect.php");
include("shared/processes/saved-items-process.php");
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EcoRent | My Saved Items</title>
    <link rel="icon" type="image/png" href="shared/assets/img/system/ecorent-logo-2.png">

    <!-- STYLINGS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="shared/assets/css/style.css">
    <link rel="stylesheet" href="shared/assets/css/footerNav.css">
    <link rel="stylesheet" href="shared/assets/css/cart.css">
    <link rel="stylesheet" href="shared/assets/css/modal.css">

    <!-- FONTS -->
    <link rel="stylesheet" href="shared/assets/font/font.css">
</head>

<body id="cart-page">
    <?php include 'shared/components/navbar.php'; ?>

    <div class="container mt-5">

        <h1>
            <strong>
                My Saved Items
            </strong>
        </h1>

        <div class="row">
            <div class="col-12 col-md-9">
                <div class="row">
                    <div class="col">
                        <?php if (mysqli_num_rows($cartResults) > 0): ?>
                            <div class="add-all-items mt-2 mb-2 px-4 py-2 rounded-4">
                                <div class="form-check d-flex justify-content-between">
                                    <div class="d-flex mt-1">
                                        <input class="form-check-input check-custom" type="checkbox" id="selectAll">
                                        <label class="form-check-label ms-4 form-check-label-custom" for="selectAll">
                                            Select All Items
                                        </label>
                                    </div>
                                    <button class="btn btn-link p-0 trash-button" style="border: none; background: none;">
                                        <i class="bi bi-trash trash-custom"></i>
                                    </button>

                                </div>
                            </div>
                        <?php else: ?>
                            <p>Your saved items is empty. Start adding items!</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php foreach ($cartResults as $item): ?>
                            <div class="container cart-container mt-2 mb-3 px-3 py-3 rounded-4"
                                data-item-id="<?php echo $item['savedID']; ?>">
                                <div class="row p-2">
                                    <div class="col-auto d-flex align-items-center">
                                        <input class="form-check-input me-4 check-custom" type="checkbox" value=""
                                            id="defaultCheck1">
                                        <a href="product-page.php?id=<?php echo $item['itemID']; ?>">
                                            <img src="shared/assets/img/system/items/<?php echo $item['fileName']; ?>"
                                                class="rounded-2 img-fluid"
                                                style="width: 130px; height: 96px; object-fit:cover;">
                                        </a>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <h4>
                                                <?php echo $item['itemName'];
                                                ; ?>
                                            </h4>
                                        </div>
                                        <div class="row row-loc">
                                            <div class="loc-custom">
                                                <i class="bi bi-geo-alt-fill loc-custom"></i>
                                                <span class="ms-1">Brgy. San Antonio, Sto. Tomas, Batangas</span>
                                            </div>
                                        </div>
                                        <div class="row pt-1">
                                            <div>
                                                <span
                                                    class="badge rounded-pill pill-condition"><?php echo $item['conditionName'] . ' Condition'; ?></span>
                                                <span
                                                    class="badge rounded-pill pill-carbon-emission"><?php echo '-' . $item['gasEmissionSaved'] . 'kg CO₂'; ?></span>
                                            </div>
                                        </div>
                                        <div class="row pt-1">
                                            <?php if ($item['stock'] == 0): ?>
                                                <p class="mb-0 text-danger fw-bold">OUT OF STOCK</p>
                                            <?php else: ?>
                                                <p class="mb-0"><?php echo $item['stock']; ?>
                                                    <?php echo $item['stock'] <= 1 ? 'stock' : 'stocks'; ?> available
                                                </p>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="col-auto d-flex ps-5">
                                        <h4 class="price-custom">
                                            <?php echo '₱' . $item['pricePerDay']; ?>
                                        </h4>
                                        <h4 class="per-day-custom">
                                            /day
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="container cart-container mt-2 mb-2 p-4 rounded-4">
                    <div class="row">
                        <div class="col">
                            <h5>
                                Saved Items
                            </h5>
                            <h4 class="est-price">
                                <strong>
                                    <?php echo $cartCount; ?>
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <a href="index.php"><button class="btn btn-checkout mt-2"><strong>
                                        Back to Home
                                    </strong></button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM REMOVAL MODAL -->
    <div class="modal fade" id="removeItemModal" tabindex="-1" aria-labelledby="removeItemModalLabel" aria-hidden="true"
        data-bs-theme="dark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title  w-100 text-center fs-4" id="confirmationLogout">Confirm removal
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    Are you sure you want to remove all selected items?
                </div>
                <div class="container d-flex justify-content-end my-3">
                    <button type="button" class="btn-logout-denied text-center mx-2" data-bs-dismiss="modal"
                        name="btnDenied">No</button>
                    <button type="submit" class="btn-logout-confirmed text-center" name="btnConfirmed">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- NO ITEMS TO DELETE TOAST NOTIFICATION -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="emptyCartToast" class="toast align-items-center text-bg-warning border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Please select at least one item to delete.
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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

    <!-- ITEM CHECKBOXES -->
    <script>
        var selectAllCheckbox = document.getElementById('selectAll');
        var itemCheckboxes = document.querySelectorAll('.check-custom');

        selectAllCheckbox.addEventListener('change', function () {
            for (var i = 0; i < itemCheckboxes.length; i++) {
                if (itemCheckboxes[i] !== selectAllCheckbox) {
                    itemCheckboxes[i].checked = selectAllCheckbox.checked;
                }
            }
        });
        for (var i = 0; i < itemCheckboxes.length; i++) {
            if (itemCheckboxes[i] !== selectAllCheckbox) {
                itemCheckboxes[i].addEventListener('change', function () {
                    var allChecked = true;
                    for (var j = 0; j < itemCheckboxes.length; j++) {
                        if (itemCheckboxes[j] !== selectAllCheckbox && !itemCheckboxes[j].checked) {
                            allChecked = false;
                            break;
                        }
                    }
                    selectAllCheckbox.checked = allChecked;
                });
            }
        }
    </script>

    <!-- REMOVE ITEMS FROM CART -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var trashButton = document.querySelector('.trash-custom');
            var selectAllCheckbox = document.getElementById('selectAll');
            var modal = new bootstrap.Modal(document.getElementById('removeItemModal'));
            var toast = new bootstrap.Toast(document.getElementById('emptyCartToast'))
            var confirmButton = document.querySelector('.btn-logout-confirmed');

            var cartIDsString = '';

            trashButton.addEventListener('click', function () {
                var selectedCards = document.querySelectorAll('.cart-container input[type="checkbox"]:checked');

                if (selectedCards.length === 0) {
                    toast.show();
                    return;
                }

                var cartIDs = [];
                selectedCards.forEach(function (checkbox) {
                    var cartID = checkbox.closest('.cart-container').getAttribute('data-item-id');
                    cartIDs.push(cartID);
                });
                cartIDsString = cartIDs.join(',');

                if (selectAllCheckbox.checked) {
                    modal.show();
                } else {
                    window.location.href = 'shared/processes/remove-from-saved-items.php?cartIDs=' + cartIDsString;
                }
            });

            confirmButton.addEventListener('click', function () {
                window.location.href = 'shared/processes/remove-from-saved-items.php?cartIDs=' + cartIDsString;
            });
        });

    </script>

</body>

</html>