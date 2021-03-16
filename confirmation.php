<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/src/business/OrderService.php';
//require_once __DIR__.'/src/business/CustomerService.php';

$orderService = new OrderService;

/*
 * Handles an attepmt to directly access the page without being authorized.
 */
if (!isset($_SESSION['authorized'])) { 
    header('Location: menu.php');
    exit(0);
}

$customer = unserialize($_SESSION['customer']);
$deliveryAddress = unserialize($_SESSION['address']);
$postcode = $orderService->getDeliveryPostcode($deliveryAddress->getPostcodeId());

/*
 * Creates the basket variable that is used in the view.
 */
if (isset($_SESSION['basket'])) {
    $basket = [];
    foreach ($_SESSION['basket'] as $item) {
        $item = unserialize($item);
        $basket[] = $item;
    }
    $orderTotal = $orderService->calculateDiscountPrice($basket);
    $discountAmount = $orderService->calculateDiscountAmount($basket);
}

/*
 * unset all session variables
 */
unset($_SESSION['customer']);
unset($_SESSION['basket']);
unset($_SESSION['address']);
unset($_SESSION['authorized']);

require_once __DIR__ . '/src/presentation/confirmationPage.php';
