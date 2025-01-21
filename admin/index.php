<?php
include("Rental.php");

// RENTAL STATUS CARD
$rental = new Rental(null, null, null);
$rentalList = $rental->getRentalsData();

date_default_timezone_set('Asia/Manila');

session_start();

// If not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: admin-login.php');
    exit();
}

if (isset($_POST['btnConfirmed'])) {
    session_destroy();
    session_unset();

    // Ensure session is fully destroyed
    if (ini_get("session.use_cookies")) {
        setcookie(session_name(), '', time() - 42000, '/');
    }

    header("Location: admin-login.php");
    exit();
}

$displayItemsQuery = "SELECT items.*, attachments.*, categories.* FROM items INNER JOIN attachments ON items.itemID = attachments.itemID INNER JOIN categories ON items.categoryID = categories.categoryID WHERE items.isDeleted = 'No'";

if (isset($_GET['filterCategory'])) {
    $filterCategoryID = $_GET['filterCategory'];

    $displayItemsQuery .= " AND items.categoryID = '$filterCategoryID'";
}

$displayItemsResult = executeQuery($displayItemsQuery);

$itemCategoryQuery = "SELECT * FROM categories";
$itemCategoryResult = executeQuery($itemCategoryQuery);

$itemConditionQuery = "SELECT * FROM conditions";
$itemConditionResult = executeQuery($itemConditionQuery);

if (isset($_POST['deleteBtn'])) {
    $itemID = $_POST['itemID'];

    $deleteItemQuery = "UPDATE items SET isDeleted = 'Yes' WHERE itemID = '$itemID'";
    $deleteItemResult = executeQuery($deleteItemQuery);

    header("Location: index.php");
    exit();
}

if (isset($_POST['addItemBtn'])) {
    $itemName = mysqli_real_escape_string($conn, $_POST['itemName']);
    $itemDesc = mysqli_real_escape_string($conn, $_POST['inputDesc']);
    $itemSpec = mysqli_real_escape_string($conn, $_POST['inputSpec']);
    $pricePerDay = mysqli_real_escape_string($conn, $_POST['pricePerDay']);
    $gasEmissionSaved = mysqli_real_escape_string($conn, $_POST['gasEmissionSaved']);
    $category = mysqli_real_escape_string($conn, $_POST['selectedCategory']);
    $itemType = mysqli_real_escape_string($conn, $_POST['inputGroupType']);
    $itemCondition = mysqli_real_escape_string($conn, $_POST['inputGroupCondition']);
    $itemStock = mysqli_real_escape_string($conn, $_POST['itemStock']);

    $getNextIDQuery = "SHOW TABLE STATUS LIKE 'items'";
    $getNextIDResult = executeQuery($getNextIDQuery);
    $row = mysqli_fetch_assoc($getNextIDResult);

    $insertItemQuery = "INSERT INTO `items`(`itemName`, `description`, `itemSpecifications`, `pricePerDay`, `gasEmissionSaved`, `categoryID`, `itemType`, `conditionID`, `stock`, `location`, `listingDate`, `isFeatured`, `isDeleted`) 
    VALUES ('$itemName', '$itemDesc', '$itemSpec', '$pricePerDay', '$gasEmissionSaved', '$category', '$itemType', '$itemCondition', '$itemStock', 'Brgy. San Antonio, Sto. Tomas, Batangas', CURRENT_TIMESTAMP, 'Yes', 'No')";

    $insertItemResult = executeQuery($insertItemQuery);

    $itemID = $row['Auto_increment'];

    uploadImage('addAttachment', $itemID, 'addItem');

    header("Location: index.php#displayedItem" . $itemID);
    exit();
}

if (isset($_POST['editItemID'])) {
    $itemName = mysqli_real_escape_string($conn, $_POST['editName']);
    $itemDesc = mysqli_real_escape_string($conn, $_POST['editDesc']);
    $itemSpec = mysqli_real_escape_string($conn, $_POST['editSpec']);
    $pricePerDay = mysqli_real_escape_string($conn, $_POST['editPrice']);
    $gasEmissionSaved = mysqli_real_escape_string($conn, $_POST['editGas']);
    $category = mysqli_real_escape_string($conn, $_POST['editCategory']);
    $editType = mysqli_real_escape_string($conn, $_POST['editType']);
    $editCondition = mysqli_real_escape_string($conn, $_POST['editCondition']);
    $itemStock = mysqli_real_escape_string($conn, $_POST['editStock']);
    $itemID = $_POST['editItemID'];

    $updateItemsQuery = "UPDATE `items` SET `itemName` = '$itemName', `description` = '$itemDesc', `itemSpecifications` = '$itemSpec', 
    `pricePerDay` = '$pricePerDay', `gasEmissionSaved` = '$gasEmissionSaved', `categoryID` = '$category', `itemType` = '$editType', `conditionID` = '$editCondition', `stock` = '$itemStock', `listingUpdatedDate` = CURRENT_TIMESTAMP WHERE `itemID` = '$itemID'";

    $udpateItemsResult = executeQuery($updateItemsQuery);

    $attachment = "editAttachment" . $itemID;
    uploadImage($attachment, $itemID, 'editItem');

    header("Location: index.php#displayedItem" . $itemID);
    exit();
}

if (isset($_POST['cancelEdit'])) {
    $itemID = $_POST['cancelEdit'];

    header("Location: index.php#displayedItem" . $itemID);
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
    <link rel="icon" type="image/png" href="../shared/assets/img/system/ecorent-logo-2.png">

    <!-- STYLINGS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- FONTS -->
    <link rel="stylesheet" href="../shared/assets/font/font.css">
    <link rel="stylesheet" href="../shared/assets/css/modal.css">
    <script src="assets/js/Chart.js"></script>
</head>

<body>

    <!-- Sidebar (Off-canvas) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sideBar" aria-labelledby="sideBarLabel">
        <div class="offcanvas-header">
            <div class="logo-brand ps-5 pt-3 pb-3"><img src="../shared/assets/img/system/ecorent-logo-2.png"
                    class="logo"></div>
        </div>
        <div class="offcanvas-body">
            <div class="navigations">
                <div class="nav-button dashboard p-3" id="sidebtn1" onclick="showContent('sidebtn1')">
                    <i class="fa-solid fa-chart-line pe-3"></i> Dashboard
                </div>
                <div class="nav-button pendings p-3" id="sidebtn2" onclick="showContent('sidebtn2')">
                    <i class="fa-solid fa-hourglass-half pe-3"></i> Pending Requests
                </div>
                <div class="nav-button pickups p-3" id="sidebtn3" onclick="showContent('sidebtn3')">
                    <i class="fa-solid fa-box-open pe-3"></i> For Pick-Ups
                </div>
                <div class="nav-button rentals p-3" id="sidebtn4" onclick="showContent('sidebtn4')">
                    <i class="fa-solid fa-book pe-3"></i> Active Rentals
                </div>
                <div class="nav-button listings p-3" id="sidebtn5" onclick="showContent('sidebtn5')">
                    <i class="fa-solid fa-list pe-3"></i> Manage Listings
                </div>
            </div>
            <div class="settings ps-2 pt-5">
                <div class="logout p-3" data-bs-toggle="modal" data-bs-target="#logoutModal"><i
                        class="fa-solid fa-right-from-bracket pe-3 py-3"></i>Log out</div>
            </div>
        </div>
    </div>

    <!-- Side Bar -->
    <div class="sidebar" id="sideBar">
        <div class="top d-flex">
            <div class="exit my-auto px-2 rounded-3" onclick="hideSidebar()"><i class="fa-solid fa-arrow-left"></i>
            </div>
            <div class="logo-brand ps-5 pt-3 pb-3"><img src="../shared/assets/img/system/ecorent-logo-2.png"
                    class="logo"></div>
        </div>
        <div class="navigations">
            <div class="nav-button dashboard p-3" id="btn1" onclick="showContent('btn1')">
                <i class="fa-solid fa-chart-line pe-3"></i> Dashboard
            </div>
            <div class="nav-button pendings p-3" id="btn2" onclick="showContent('btn2')">
                <i class="fa-solid fa-hourglass-half pe-3"></i></i> Pending Requests
            </div>
            <div class="nav-button pickups p-3" id="btn3" onclick="showContent('btn3')">
                <i class="fa-solid fa-box-open pe-3"></i></i>For Pick-Ups
            </div>
            <div class="nav-button rentals p-3" id="btn4" onclick="showContent('btn4')">
                <i class="fa-solid fa-book pe-3"></i></i> Active Rentals
            </div>
            <div class="nav-button listings p-3" id="btn5" onclick="showContent('btn5')">
                <i class="fa-solid fa-list pe-3"></i></i> Manage Listings
            </div>
            <div class="settings ps-2 pt-5">
                <div class="logout p-3" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fa-solid fa-right-from-bracket pe-3 py-3"></i> Log out
                </div>
            </div>
        </div>
    </div>

    <?php include("assets/processes/admin-logout-process.php"); ?>

    <!-- Main Content -->
    <div class="main-content">

        <!-- DASHBOARD -->
        <?php include("tabs/dashboard.php") ?>

        <!-- PENDING REQUEST -->
        <div class="content-card pendings" id="container2">
            <div class="title">
                <div class="menu" data-bs-toggle="offcanvas" data-bs-target="#sideBar" aria-controls="sideBar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Pending Requests</h1>
            </div>
            <div class="content mt-4">
                <!-- [CONTENTS] -->
                <div class="container-fluid">
                    <!-- RENTAL STATUS CARDS -->
                    <?php foreach ($rentalList as $rentalCard) {
                        if ($rentalCard->status === 'pending') {
                            echo $rentalCard->buildAdminRentalCard();
                        }
                    } ?>
                </div>
            </div>
        </div>

        <!-- FOR PICK-UPS -->
        <div class="content-card pickups" id="container3">
            <div class="title">
                <div class="menu" data-bs-toggle="offcanvas" data-bs-target="#sideBar" aria-controls="sideBar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>For Pick-Ups</h1>
            </div>
            <div class="content">
                <!-- [CONTENTS] -->
                <div class="container-fluid mt-4">
                    <?php foreach ($rentalList as $rentalCard) {
                        if ($rentalCard->status === 'pickup') {
                            echo $rentalCard->buildAdminRentalCard();
                        }
                    } ?>
                </div>
            </div>
        </div>

        <!-- ACTIVE RENTALS -->
        <div class="content-card rentals" id="container4">
            <div class="title">
                <div class="menu" data-bs-toggle="offcanvas" data-bs-target="#sideBar" aria-controls="sideBar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Active Rentals</h1>
            </div>
            <!-- CONTENTS -->
            <div class="content mt-4">
                <div class="container-fluid">
                    <?php foreach ($rentalList as $rentalCard) {
                        if ($rentalCard->status === 'on rent') {
                            echo $rentalCard->buildAdminRentalCard();
                        }
                    } ?>
                </div>
            </div>
        </div>

        <!-- MANAGE LISTINGS -->
        <div class="content-card listings" id="container5">
            <div class="title">
                <div class="menu" data-bs-toggle="offcanvas" data-bs-target="#sideBar" aria-controls="sideBar">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <h1>Manage Listings</h1>
                <!-- FILTER & BUTTON -->
                <div class="add-filter-buttons gap-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="button-text" id="filterCategory">Filter</span>
                            <i class="fa fa-chevron-down"></i>
                        </button>

                        <form method="GET" id="filterForm">
                            <input type="hidden" name="filterCategory" id="inputFilter">
                        </form>

                        <ul class="dropdown-menu">
                            <?php
                            if (mysqli_num_rows($itemCategoryResult) > 0) {
                                while ($filterCategory = mysqli_fetch_assoc($itemCategoryResult)) { ?>
                                    <li class="dropdown-item"
                                        onclick="updateFilterCategory('<?php echo $filterCategory['categoryName']; ?>','<?php echo $filterCategory['categoryID']; ?>');">
                                        <?php echo $filterCategory['categoryName']; ?></li>
                            <?php
                                }
                            }
                            ?>
                            <li><a class="dropdown-item" href="index.php">Clear</a></li>
                        </ul>
                    </div>
                    <!-- Button trigger modal -->
                    <div class="add-item-button">
                        <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                class="fa fa-plus"></i><span class="button-text">Add
                                Item</span></button>
                        <!-- Modal -->
                        <!-- Add Item Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1">
                            <div class="modal-dialog add-item-modal-dialog my-3 ">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header add-item-modal">
                                            <h1 class="modal-title fs-5 add-item-modal-text" id="staticBackdropLabel">Add
                                                Item</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body add-item-modal-body" id="add-item-modal-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12 col-md-3 add-item-frame ">
                                                        <img src="../shared/assets/img/system/bike.jpg" alt=""
                                                            class="img-fluid" id="displayAttachment">
                                                        <label for="customFile"
                                                            class="btn btn-select-main-image mb-2">Select main
                                                            image</label>
                                                        <input type="file" class="d-none" name="addAttachment" id="customFile" accept=".png, .jpg" required />
                                                    </div>

                                                    <div class="col-12 col-md-9">
                                                        <input type="text" id="addItemName" name="itemName" value="" class="form-control add-item-input mb-2"
                                                            placeholder="Item Name" required />
                                                        <input type="hidden" name="inputDesc" id="inputDesc" value="">
                                                        <textarea
                                                            class="form-control add-item-input mb-2 add-item-textarea-desc"
                                                            placeholder="Description" id="addItemDesc" required></textarea>
                                                        <input type="hidden" name="inputSpec" id="inputSpec" value="">
                                                        <textarea
                                                            class="form-control add-item-input add-item-textarea-specs"
                                                            placeholder="Specifications" id="addItemSpec" required></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-12 col-md-4">
                                                        <div class="mb-3">
                                                            <label for="inputGroupRate" class="form-label">Rate Type</label>
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text rate-type-custom">₱</span>
                                                                <input type="number" step="0.01" class="form-control add-item-input" id="inputGroupRate" name="pricePerDay" value="" required>
                                                                <span class="input-group-text rate-type-custom">PER
                                                                    DAY</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="mb-3">
                                                            <div class="inputGroupSelect01" data-bs-theme="dark">
                                                                <label for="inputGroupShipping">Shipping mode</label>
                                                                <select class="form-select mt-2 shipping-mode-custom"
                                                                    id="inputGroupShipping">
                                                                    <option selected>For Pick-up</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="inputGroupC02">Potential gas
                                                                emission
                                                                saved</label>
                                                            <div class="input-group mb-3">
                                                                <input type="number" step="0.01" class="form-control add-item-input"
                                                                    id="inputGroupC02" name="gasEmissionSaved" value="" required>
                                                                <span class="input-group-text rate-type-custom">kg
                                                                    CO₂</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer add-item-modal-footer ">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-12 col-md-3">
                                                        <div class="inputGroupCategory" data-bs-theme="dark">
                                                            <label for="inputGroupCategory"
                                                                class="form-label mb-0 me-2 mt-2">Category</label>
                                                            <select class="form-select category-custom mt-2"
                                                                id="inputGroupCategory" name="selectedCategory" value="">
                                                                <?php mysqli_data_seek($itemCategoryResult, 0);
                                                                if (mysqli_num_rows($itemCategoryResult) > 0) {
                                                                    while ($addItemCategory = mysqli_fetch_assoc($itemCategoryResult)) { ?>
                                                                        <option value="<?php echo $addItemCategory['categoryID']; ?>"><?php echo $addItemCategory['categoryName']; ?></option>
                                                                <?php
                                                                    }
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="inputGroupType"
                                                            class="form-label mb-0 me-2 mt-2">Type</label>
                                                        <input type="text" class="form-control add-item-input mt-2"
                                                            id="inputGroupType" name="inputGroupType" />
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <div class="inputGroupCondition" data-bs-theme="dark">
                                                            <label for="inputGroupCondition"
                                                                class="form-label mb-0 me-2 mt-2">Condition</label>
                                                            <select class="form-select category-custom mt-2"
                                                                id="inputGroupCondition" name="inputGroupCondition">
                                                                <?php
                                                                if (mysqli_num_rows($itemConditionResult) > 0) {
                                                                    while ($condition = mysqli_fetch_assoc($itemConditionResult)) {
                                                                ?>
                                                                        <option value="<?php echo $condition['conditionID']; ?>"><?php echo $condition['conditionName']; ?></option>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-3">
                                                        <label for="inputGroupStocks"
                                                            class="form-label mb-0 me-2 mt-2">Stocks</label>
                                                        <input type="number" class="form-control add-item-input mt-2 mb-4"
                                                            id="inputGroupStocks" name="itemStock" value="" required />
                                                    </div>
                                                    <div
                                                        class="col-12 col-md-12 add-item-btn-custom d-flex justify-content-center align-items-center">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal" onclick="cancelAddItem();">Cancel</button>
                                                        <button type="submit"
                                                            class="btn btn-primary ms-2 add-item-btn-save" name="addItemBtn" onclick="syncAddItemTextArea();">Add Item</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Edit Item Modal -->
                        <?php if (mysqli_num_rows($displayItemsResult) > 0) {
                            while ($editModalItem = mysqli_fetch_assoc($displayItemsResult)) {
                                $imageID = htmlspecialchars($editModalItem['itemID'], ENT_QUOTES, 'UTF-8');
                        ?>
                                <div class="modal fade" id="staticBackdrop<?php echo $editModalItem['itemID']; ?>" data-bs-backdrop="static" data-bs-keyboard="false"
                                    tabindex="-1">
                                    <div class="modal-dialog add-item-modal-dialog mt-3 ">
                                        <!-- Cancel Edit Form -->
                                        <form method="POST" id="cancelForm<?php echo $editModalItem['itemID']; ?>">
                                            <input type="hidden" name="cancelEdit" value="<?php echo $editModalItem['itemID']; ?>">
                                        </form>
                                        <!-- Edit Modal Form -->
                                        <form method="POST" id="form<?php echo $editModalItem['itemID']; ?>" enctype="multipart/form-data" onsubmit="">
                                            <input type="hidden" name="editItemID" value="<?php echo $editModalItem['itemID']; ?>">
                                            <div class="modal-content">
                                                <div class="modal-header add-item-modal">
                                                    <h1 class="modal-title fs-5 add-item-modal-text" id="staticBackdropLabel<?php echo $editModalItem['itemID']; ?>">Edit
                                                        Item</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body add-item-modal-body" id="add-item-modal-body<?php echo $editModalItem['itemID']; ?>">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 col-md-3 add-item-frame ">
                                                                <img src="../shared/assets/img/system/items/<?php echo $editModalItem['fileName']; ?>" alt=""
                                                                    class="img-fluid" id="imgContainer<?php echo $editModalItem['itemID']; ?>">
                                                                <label for="customFile<?php echo $editModalItem['itemID']; ?>"
                                                                    class="btn btn-primary btn-select-main-image mb-2">Select main
                                                                    image</label>
                                                                <input type="file" class="d-none" name="editAttachment<?php echo $editModalItem['itemID']; ?>" id="customFile<?php echo $editModalItem['itemID']; ?>" accept=".png, .jpg" required />
                                                            </div>

                                                            <div class="col-12 col-md-9">
                                                                <input type="text" class="form-control add-item-input mb-2 "
                                                                    placeholder="Item Name" name="editName" value="<?php echo $editModalItem['itemName']; ?>" />
                                                                <textarea
                                                                    class="form-control add-item-input mb-2 add-item-textarea-desc"
                                                                    placeholder="Description" name="editDesc" required><?php echo $editModalItem['description']; ?></textarea>
                                                                <textarea
                                                                    class="form-control add-item-input add-item-textarea-specs"
                                                                    placeholder="Specifications" name="editSpec" required><?php echo $editModalItem['itemSpecifications']; ?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-4">
                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label for="inputGroupRate<?php echo $editModalItem['itemID']; ?>" class="form-label">Rate Type</label>
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text rate-type-custom">₱</span>
                                                                        <input type="number" step="0.01" class="form-control add-item-input" id="inputGroupRate<?php echo $editModalItem['itemID']; ?>" name="editPrice" value="<?php echo $editModalItem['pricePerDay']; ?>" required>
                                                                        <span class="input-group-text rate-type-custom">PER
                                                                            DAY</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <div class="inputGroupSelect01" data-bs-theme="dark">
                                                                        <label for="inputGroupShipping<?php echo $editModalItem['itemID']; ?>">Shipping mode</label>
                                                                        <select class="form-select mt-2 shipping-mode-custom"
                                                                            id="inputGroupShipping<?php echo $editModalItem['itemID']; ?>">
                                                                            <option selected>For Pick-up</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 col-md-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="inputGroupC02">Potential gas
                                                                        emission
                                                                        saved</label>
                                                                    <div class="input-group mb-3">
                                                                        <input type="number" step="0.01" class="form-control add-item-input"
                                                                            id="inputGroupC02" name="editGas" value="<?php echo $editModalItem['gasEmissionSaved']; ?>" required>
                                                                        <span class="input-group-text rate-type-custom">kg
                                                                            CO₂</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer add-item-modal-footer ">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 col-md-3">
                                                                <div class="inputGroupCategory" data-bs-theme="dark">
                                                                    <label for="inputGroupCategory<?php echo $editModalItem['itemID']; ?>"
                                                                        class="form-label mb-0 me-2 mt-2">Category</label>
                                                                    <select class="form-select category-custom mt-2"
                                                                        id="inputGroupCategory<?php echo $editModalItem['itemID']; ?>" name="editCategory" value="<?php echo $editModalItem['categoryName']; ?>">
                                                                        <?php if (mysqli_num_rows($itemCategoryResult) > 0) {
                                                                            mysqli_data_seek($itemCategoryResult, 0);
                                                                            while ($editItemCategory = mysqli_fetch_assoc($itemCategoryResult)) {
                                                                        ?>
                                                                                <option <?php echo ($editModalItem['categoryID'] == $editItemCategory['categoryID']) ? 'selected' : ''; ?> value="<?php echo $editItemCategory['categoryID']; ?>"><?php echo $editItemCategory['categoryName']; ?></option>
                                                                        <?php
                                                                            }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-3">
                                                                <label for="inputGroupType<?php echo $editModalItem['itemID']; ?>"
                                                                    class="form-label mb-0 me-2 mt-2">Type</label>
                                                                <input type="text" class="form-control add-item-input mt-2"
                                                                    id="inputGroupType<?php echo $editModalItem['itemID']; ?>" name="editType" value="<?php echo $editModalItem['itemType']; ?>" />
                                                            </div>
                                                            <div class="col-12 col-md-3">
                                                                <div class="inputGroupCondition" data-bs-theme="dark">
                                                                    <label for="inputGroupCondition<?php echo $editModalItem['itemID']; ?>"
                                                                        class="form-label mb-0 me-2 mt-2">Condition</label>
                                                                    <select class="form-select category-custom mt-2"
                                                                        id="inputGroupCondition<?php echo $editModalItem['itemID']; ?>" name="editCondition">
                                                                        <?php mysqli_data_seek($itemConditionResult, 0);
                                                                        if (mysqli_num_rows($itemConditionResult) > 0) {
                                                                            while ($editCondition = mysqli_fetch_assoc($itemConditionResult)) {
                                                                        ?>
                                                                                <option <?php echo $editModalItem['conditionID'] == $editCondition['conditionID'] ? 'selected' : ''; ?> value="<?php echo $editCondition['conditionID']; ?>"><?php echo $editCondition['conditionName']; ?></option>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-3">
                                                                <label for="inputGroupStocks<?php echo $editModalItem['itemID']; ?>"
                                                                    class="form-label mb-0 me-2 mt-2">Stocks</label>
                                                                <input type="number" class="form-control add-item-input mt-2 mb-4"
                                                                    id="inputGroupStocks<?php echo $editModalItem['itemID']; ?>" name="editStock" value="<?php echo $editModalItem['stock']; ?>" required />
                                                            </div>
                                                            <div
                                                                class="col-12 col-md-12 add-item-btn-custom d-flex justify-content-center align-items-center">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal" onclick="document.getElementById('cancelForm<?php echo $editModalItem['itemID']; ?>').submit(); ">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-primary ms-2 add-item-btn-save" onclick="document.getElementById('form<?php echo $editModalItem['itemID']; ?>').submit();">Save
                                                                    Changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        <?php
                                echo "<script>
                            const displayAttachment{$imageID} = document.getElementById('imgContainer{$imageID}');
                            const customFile{$imageID} = document.getElementById('customFile{$imageID}');
                
                                customFile{$imageID}.addEventListener('change', (event) => {
                                    if (event?.target?.files && event.target.files[0]) {
                                        displayAttachment{$imageID}.src = URL.createObjectURL(event.target.files[0]);
                                        displayAttachment{$imageID}.load();
                                    } 
                                });
                            </script>";
                            }
                        } ?>

                    </div>
                </div>
            </div>

            <div class="content mt-5">
                <!-- CONTENTS -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="manage-listings">
                            <h3>Filter By:
                                <span id="filterCategoryName">
                                    <?php
                                    if (isset($_GET['filterCategory'])) {
                                        $selectedCategoryID = $_GET['filterCategory'];
                                        $categoryQuery = "SELECT categoryName FROM categories WHERE categoryID = '$selectedCategoryID'";
                                        $categoryResult = executeQuery($categoryQuery);
                                        if (mysqli_num_rows($categoryResult) > 0) {
                                            $category = mysqli_fetch_assoc($categoryResult);
                                            echo " " . $category['categoryName'];
                                        }
                                    }
                                    ?>
                                </span>
                            </h3>
                            <!-- Generate With PHP -->
                            <?php mysqli_data_seek($displayItemsResult, 0);
                            if (mysqli_num_rows($displayItemsResult)) {
                                while ($items = mysqli_fetch_assoc($displayItemsResult)) { ?>
                                    <form method="POST">
                                        <div class="card-body-listings p-3">
                                            <div class="listings-content">
                                                <div class="order-content" id="displayedItem<?php echo $items['itemID']; ?>">
                                                    <img src="../shared/assets/img/system/items/<?php echo $items['fileName']; ?>" alt="" class="img-fluid">
                                                    <div class="listings-info">
                                                        <input type="hidden" name="itemID" value="<?php echo $items['itemID'] ?>">
                                                        <h4><?php echo $items['itemName']; ?></h4>
                                                        <h5>Available stocks: <?php echo $items['stock']; ?></h5>
                                                    </div>
                                                </div>
                                                <div class="listings-buttons">
                                                    <button type="submit" name="deleteBtn" class="btn btn-delete"><i class="fa fa-trash-can"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-edit" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?php echo $items['itemID']; ?>"><i class="fa fa-pen-to-square"></i></button>
                        </div>
                    </div>
                </div>
            <?php
                                }
                            } else {
            ?>
            <div class="text-center mt-5">
                <h1>No Items</h1>
            </div>
        <?php
                            }
        ?>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/49a3347974.js" crossorigin="anonymous"></script>
    <script src="assets/js/analytics.js"></script>
    <script>
        var containers = [
            document.getElementById("container1"),
            document.getElementById("container2"),
            document.getElementById("container3"),
            document.getElementById("container4"),
            document.getElementById("container5"),
        ];

        var buttons = [
            document.getElementById("btn1"),
            document.getElementById("btn2"),
            document.getElementById("btn3"),
            document.getElementById("btn4"),
            document.getElementById("btn5"),
        ];

        var sidebuttons = [
            document.getElementById("sidebtn1"),
            document.getElementById("sidebtn2"),
            document.getElementById("sidebtn3"),
            document.getElementById("sidebtn4"),
            document.getElementById("sidebtn5"),
        ];

        var offcanvasElement = document.getElementById('sideBar');
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement);

        function showContent(btnID) {
            offcanvas.hide();
            var index = btnID[btnID.length - 1] - 1;

            localStorage.setItem("activeSection", btnID);

            buttons.forEach((button, i) => {
                button.style.backgroundColor = i === index ? '#7F9D5A' : '';
            });

            sidebuttons.forEach((sidebutton, i) => {
                sidebutton.style.backgroundColor = i === index ? '#7F9D5A' : '';
            });

            containers.forEach((container, i) => {
                container.style.display = i === index ? 'block' : 'none';
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var savedSection = localStorage.getItem("activeSection") || "btn1";
            showContent(savedSection);
        });

        function cancelAddItem() {
            document.getElementById('addItemName').value = "";
            document.getElementById('addItemDesc').value = "";
            document.getElementById('addItemSpec').value = "";
            document.getElementById('inputGroupRate').value = "";
            document.getElementById('inputGroupC02').value = "";
            document.getElementById('inputGroupStocks').value = "";
            document.getElementById('attachment').value = "";
        }

        function syncAddItemTextArea() {
            document.getElementById('inputDesc').value = document.getElementById('addItemDesc').value;
            document.getElementById('inputSpec').value = document.getElementById('addItemSpec').value;
        }

        function syncEditItemTextArea() {
            document.getElementById('inputDesc').value = document.getElementById('addItemDesc').value;
            document.getElementById('inputSpec').value = document.getElementById('addItemSpec').value;
        }

        function updateFilterCategory(categoryName, categoryID) {
            document.getElementById('inputFilter').value = categoryID;
            document.getElementById('filterForm').submit();
        }

        const displayAttachment = document.getElementById('displayAttachment');
        const customFile = document.getElementById('customFile');

        customFile.addEventListener('change', (event) => {
            if (event?.target?.files && event.target.files[0]) {
                displayAttachment.src = URL.createObjectURL(event.target.files[0]);
                displayAttachment.load();
            }
        });
    </script>

</body>

</html>