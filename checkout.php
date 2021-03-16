<?php
declare(strict_types=1);
session_start();
session_regenerate_id();

require_once __DIR__ . '/src/business/OrderService.php';
require_once __DIR__ . '/src/business/CustomerService.php';

$orderService = new OrderService;
$customerService = new CustomerService;
$customer = unserialize($_SESSION['customer']);

// csrf protection
if (isset($_SESSION['token'])) {
    $oldToken = $_SESSION['token'];
}

$customerService = new CustomerService;
$token = md5(uniqid('',true));
$_SESSION['token'] = $token;

/*
 * Create the basket and calculate order total and discount amount.
 */
$basket = [];
foreach ($_SESSION['basket'] as $item) {
    $item = unserialize($item);
    $basket[] = $item;
}
$orderTotal = $orderService->calculateDiscountPrice($basket);
$discountAmount = $orderService->calculateDiscountAmount($basket);

/*
 * Handles an attepmt to directly access the page without being authorized.
 */
if (!isset($_SESSION['authorized'])) { 
    header('Location: menu.php');
    exit(0);
}

/*
 * Handles a checkout request.
 */
if ((isset($_POST['command'])) && ($_POST['command'] === 'checkout')) {
    $customer = unserialize($_SESSION['customer']);
    $deliveryAddress = unserialize($_SESSION['address']);
    $customerId = $customer->getCustomerId();
    $address = $deliveryAddress->getAddress();
    $postcodeId = $deliveryAddress->getPostcodeId();
    //$tz = ini_get('date.timezone'); 
    //$dtz = new DateTimeZone($tz);
    //$dt = new DateTime('now', $dtz);
    //$dt = $dt->format('Y-m-d G:i:s');
    //var_dump($dt);die;
    $dt = date('Y-m-d G:i:s');
    //var_dump($dt);die;
    $orderService->addOrder($customerId, $dt, $orderTotal, $discountAmount, $basket, $address, $postcodeId);
    header('Location: confirmation.php');
    exit(0);
}

/*
 * Handles a request to change delivery address.
 * Gets all the postcodes where delivery is available.
 */
if ((isset($_GET['changeAddress'])) && ($_GET['changeAddress'] === 'true')) {
    $showAddressForm = true;
    $postcodes = $orderService->getAllDeliveryAddresses();
}

/*
 * Creates the new delivery address if requested.
 * Otherwise creates the delivery address using the customers address.
 */
if ((isset($_POST['command'])) && ($_POST['command'] === 'changeAddress')) {
    if ((isset($_SESSION['token'])) && ($_POST['token'] == $oldToken)) {
        $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING));
        $postcodeId = trim(filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING));
        $deliveryAddress = $orderService->createDeliveryAddress($customer->getCustomerId(), $address, (int) $postcodeId);
        $_SESSION['address'] = serialize($deliveryAddress);
        $postcode = $orderService->getDeliveryPostcode((int) $postcodeId);
        $deliveryPossible = true;
        $showAddressForm = false;
    }
} else {
    $deliveryAddress = $orderService->createDeliveryAddress($customer->getCustomerId(), $customer->getAddress(), $customer->getPostcodeId());
    $_SESSION['address'] = serialize($deliveryAddress);
    $postcode = $customerService->getCustomerPostcode($customer->getPostcodeId());
    $deliveryPossible = $orderService->checkDeliveryIsPossible($postcode->getPostcode());
}


require_once __DIR__ . '/src/presentation/checkoutPage.php';
