<?php

include("shared/classes/Item.php");
include("shared/classes/User.php");
class Rental
{
    public $rentalID;
    public $itemID;
    public $renterID;
    public $itemName;
    public $itemDisplayImg;
    public $status;
    public $reservationDate;
    public $pickupDate;
    public $rentalPeriod;
    public $dueDate;
    public $renter;
    public $renterAddress;
    public $itemAddress;
    public $totalSavedCO2;
    public $itemUnitPrice;
    public $itemQuantity;
    public $itemSecurityDeposit;
    public $totalAmountPayable;
    public $renterMessage;
    public function __construct($rentalID, $itemID, $renterID)
    {
        $this->rentalID = $rentalID;
        $this->itemID = $itemID;
        $this->renterID = $renterID;

        // DEFAULT ADDRESS
        $this->itemAddress = 'Brgy. San Antonio, Sto.Tomas, Batangas';
    }

    function getRentalsData()
    {
        $query = "SELECT * FROM rentals 
        LEFT JOIN items ON rentals.itemID = items.itemID
        LEFT JOIN attachments ON items.itemID = attachments.itemID
        ORDER BY rentals.rentalID DESC";
        $result = executeQuery($query);

        $rentals = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $r = new Rental($row['rentalID'], $row['itemID'], $row['renterID']);
            $r->renterID = $row['renterID'];
            $r->itemName = $row['itemName'];
            $r->status = $row['rentalStatus'];
            $r->itemDisplayImg = $row['fileName'];
            $r->reservationDate = $row['reservationDate'];
            $r->pickupDate = $row['startRentalDate'];
            $r->dueDate = $row['endRentalDate'];
            $r->rentalPeriod = $row['rentalPeriod'];
            $r->itemUnitPrice = $row['pricePerDay'];
            $r->itemQuantity = $row['itemQuantity'];
            $r->totalAmountPayable = $row['totalPrice'];

            array_push($rentals, $r);
        }

        return $rentals;
    }

    // BUILD RENTAL STATUS CARD FOR USER VIEW
    function buildRentalCard()
    {

        $formattedDate = date('M. d, Y', strtotime($this->dueDate));
        $formattedDate2 = date('M. d, Y', strtotime($this->pickupDate));

        return '<div class="item-card mt-3 p-3">
                                <div class="row">
                                    <div class="top col-12 col-md-8 d-flex order-md-1 order-2">
                                    <img src="shared/assets/img/system/items/' . $this->showItemDisplayImage($this->itemDisplayImg) . '" alt=""
                                            class="item-display-img img-fluid">
                                        <div class="item-info ps-2 ps-xl-3 pt-3 pt-md-3 pt-xl-0 d-flex flex-column">
                                            <h3 class="item-name">' . $this->itemName . '</h3>
                                            <div class="location">
                                                <i class="fa-solid fa-location-dot"></i><span
                                                    class="ps-2 location">' . $this->itemAddress . '</span>
                                            </div>
                                            <div class="rental-time">
                                                <i class="fa-regular fa-clock"></i><span class="ps-2 rental-time">Rented
                                                    for
                                                    ' . $this->rentalPeriod . ' ' . (($this->rentalPeriod > 1) ? 'days' : 'day') . '</span>
                                            </div>
                                            <div class="basket">
                                                <i class="fa-solid fa-basket-shopping"></i><span
                                                    class="ps-2 quantity">x' . $this->itemQuantity . '</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 order-md-2 order-1 mb-3">
                                        ' . $this->showBadge($this->status) . '
                                    </div>
                                </div>
                                <hr class="my-3">
                                <div class="transac">
                                    <div class="p-2 w-100">
                                        <div class="time-period ' . $this->showInfo($this->status) . '">
                                            <div class="due">
                                                <i class="fa-regular fa-calendar"></i>
                                                Booked:<span class="ps-2 rental-time">' . $formattedDate . '</span>
                                            </div>
                                            <div class="due">
                                                <i class="fa-regular fa-calendar"></i>
                                                Due:<span class="ps-2 rental-time">' . $formattedDate2 . '</span>
                                            </div>
                                        </div>
                                        <div class="status-tip py-2 py-lg-3">
                                            ' . $this->showTip($this->status) . '
                                        </div>
                                    </div>
                                    <div class="p-2 flex-shrink-1">
                                        <div class="total-payment d-flex">
                                            <span class="d-flex align-items-center">
                                                ' . ($this->showPaymentStatus($this->status)) . '</span>
                                            <span class="payment-number ps-5 text-end">₱' . $this->totalAmountPayable . '</span>
                                        </div>
                                        ' . $this->showActionButton($this->status) . '
                                    </div>
                                </div>
                            </div>';
    }

    // BUILD RENTAL STATUS CARD FOR ADMIN VIEW
    function buildAdminRentalCard()
    {
        return '<div class="row">
                        <a href="#" class="active-rentals">
                            <div class="card-body-rentals">
                                <div class="rentals-content">
                                    <div class="order-content">
                                        <img src="assets/img/system/items/' . $this->itemDisplayImg . '" alt="" class="img-fluid">
                                        <h4>' . $this->itemName . '</h4>
                                    </div>
                                    <div class="actions">
                                        <button class="btn-hand-in d-none btn-update-status rounded-3 mx-2 mx-md-5">RECEIVED</button>
                                        <a href="transaction-page.php?rentalID=' . $this->rentalID . '">
                                            <div class="btn-see-details rounded-4">
                                                <button class=""><i class="fa fa-chevron-right"></i></button>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>';
    }

    // DYNAMIC SETTINGS FUNCTIONS FOR RENTAL STATUS CARD (USER VIEW)
    function showInfo($status)
    {
        switch ($status) {
            case 'pending':
                return 'd-none';
            case 'pickup':
                return 'd-none';
            case 'onrent':
                return 'd-block';
            case 'returned';
                return 'd-none';
            case 'cancelled':
                return 'd-none';
            default:
                return 'd-block';
        }
    }
    function showTip($status)
    {
        switch ($status) {
            case 'pending':
                return 'Waiting for your item to be approved.';
            case 'pickup':
                return 'Please pick-up your item at ' . $this->itemAddress . ' on ' . $this->reservationDate . '.';
            case 'onrent':
                return '';
            case 'overdue';
                return 'Please return the item immediately to prevent penalties!';
            case 'extended':
                return 'Please prepare exact amount upon return.';
            case 'returned':
                return '';
            case 'cancelled':
                return '';
            default:
                return '';
        }
    }

    function showActionButton($status)
    {
        if ($status == 'pending' || $status == 'pickup') {
            return '<div class="action-button">
                        <div class="text-center text-md-end mt-3 mt-lg-5 mb-3">
                            <form method="POST">
                                <input type="hidden" name="rentalID" value="' . $this->rentalID . '">
                                <button name="btnCancelBooking" type="text" class="btn-action btn-cancel">Cancel Booking</button>
                            </form>
                        </div>
                    </div>';
        } else if ($status == 'onrent' || $status == 'overdue' || $status == 'extended') {
            return '<div class="action-button">
                                            <div class="text-center text-md-end mt-3 mt-lg-5 mb-3">
                                                <button type="submit" class="btn-action">Extend</button>
                                            </div>
                                        </div>';
        } else if ($status == 'returned' || $status == 'cancelled') {
            return '<div class="action-button">
                                            <div class="text-center text-md-end mt-3 mt-lg-5 mb-3">
                                                <a href="product-page.php?id=' . $this->itemID . '">
                                                    <button type="submit" class="btn-action" style="white-space: nowrap;">Rent Again</button>
                                                </a>
                                            </div>
                                        </div>';
        } else {
            return '';
        }
    }

    function showBadge($status)
    {
        $badgeStyle = '';
        $displayStatus = '';

        ($status != 'overdue') ? $badgeStyle = '' : $badgeStyle = 'badge-overdue';

        switch ($status) {
            case 'pending':
                $displayStatus = 'pending';
                break;
            case 'pickup':
                $displayStatus = 'pickup';
                break;
            case 'onrent':
                $displayStatus = 'on rent';
                break;
            case 'overdue':
                $displayStatus = 'overdue';
                break;
            case 'extended':
                $displayStatus = 'extended';
                break;
            case 'returned':
                $displayStatus = 'returned';
                break;
            case 'cancelled':
                $displayStatus = 'cancelled';
                break;
            default:
                $displayStatus = 'processing';
                break;
        }

        return '<div class="status-badge ' . $badgeStyle . ' text-center">
                                            ' . strtoupper($displayStatus) . '
                                        </div>';
    }

    function showTimeAlert($status)
    {
        ($status == 'overdue') ? 'd-none' : 'd-block';
    }

    function showItemDisplayImage($fileName)
    {
        $itemDisplayImg = empty($itemDisplayImg) ? $fileName : "item-default-dp.png";
        return $itemDisplayImg;
    }

    function showPaymentStatus($status)
    {
        if ($status === 'pending' || $status === 'cancelled') {
            return 'Total payment:';
        } else if ($status === 'onrent' || $status === 'overdue' || $status === 'extended') {
            return 'Total payment upon return:';
        } else if ($status === 'returned') {
            return '<span style="white-space: pre;">Total payment<br>paid:
                    </span>';
        } else {
            return 'Payment:';
        }
    }

    function updateOverdueRentals()
    {
        $query = "UPDATE rentals 
              SET rentalStatus = 'overdue' 
              WHERE rentalStatus = 'onrent' AND endRentalDate < NOW()";

        $result = executeQuery($query);
    }

}
?>