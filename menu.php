<?php
session_start();
session_regenerate_id();

require_once __DIR__ . '/src/business/OrderService.php';

$orderService = new OrderService;

/*
 * Handles the user request to proceed to checkout.
 */
if ((isset($_POST['command'])) && ($_POST['command'] === 'checkout')) {
    if ((isset($_SESSION['customer'])) || (isset($_SESSION['guest']))) {
        header('Location: checkout.php');
        exit(0);
    } else {
        header('Location: customerLogin.php');
        exit(0);
    }
}

/*
 * Removes an item from the basket.
 */
if (isset($_GET['remove'])) {
    $itemToRemove = $_GET['remove'];
    $_SESSION['basket'] = $orderService->removeItemFromBasket($_SESSION['basket'], (int) $itemToRemove);
}

/*
 * Adds an item to the basket.
 */
if (isset($_GET['pizza'])) {
    $pizza = $orderService->getPizzaDetails($_GET['pizza']);
    $_SESSION['basket'][] = serialize($pizza); 
}

/*
 * Creates the basket that is used in the view from the session variable.
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

$menu = $orderService->getMenu(); // array that holds all the product instances.

require_once __DIR__ . '/src/presentation/orderPage.php';
