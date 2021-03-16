<?php
declare(strict_types=1);

require_once __DIR__ . '/../data/ProductDAO.php';
require_once __DIR__ . '/../data/CustomerDAO.php';
require_once __DIR__ . '/../data/CustomerOrderDAO.php';
require_once __DIR__ . '/../data/OrderItemDAO.php';
require_once __DIR__ . '/../data/DeliveryAddressDAO.php';
require_once __DIR__ . '/../data/PostcodeDAO.php';


class OrderService
{
    public function getMenu() 
    {
        $productDAO = new ProductDAO;
        $menu = $productDAO->findAll();
        return $menu;
    }

    public function getPizzaDetails(int $id)
    {
        $productDAO = new ProductDAO;
        $product = $productDAO->findById($id);
        
        return $product;
    }

    public function removeItemFromBasket(array $basket, $itemId) 
    {
        foreach ($basket as $key => $value) {
            $item = unserialize($value);
            
            if ($item->getProductId() === $itemId) {
                unset($basket[$key]);
            break;
            }
        }
        
        return $basket;
    }

    public function calculateTotalPrice(array $basket)
    {
        $total = 0;
        foreach ($basket as $item) {
            $price = $item->getPrice();
            $total += $price;
        }
        return $total;
    }

    private function applyDiscount(Product $item) 
    {
        $price = $item->getPrice();
        if ($item->getDiscount() > 0) {
            $price = $item->getDiscount() * $price;
        }

        return $price;
    }

    public function calculateDiscountAmount(array $basket)
    {
        return $this->calculateTotalPrice($basket) - $this->calculateDiscountPrice($basket);
    }

    public function calculateDiscountPrice(array $basket)
    {
        $discountPrice = 0;
        foreach ($basket as $item) {
            $price = $this->applyDiscount($item);
            $discountPrice += $price;
        }
        return $discountPrice;
    }

    public function addOrder(int $customerId, string $dateTime, float $total, float $discount, array $basket, string $address, int $postcodeId) 
    {
	$customerOrderDAO = new CustomerOrderDAO;
        $customerOrderDAO->createCustomerOrder($customerId, $dateTime, $total, $discount);
        $order = $customerOrderDAO->findOrderByDateTime($dateTime); 

        $orderItemDAO = new OrderItemDAO;
        foreach ($basket as $item) {
            $orderItemDAO->createOrderItem($order->getOrderId(), $item->getProductId());
        }

        $deliveryAddressDAO = new DeliveryAddressDAO;
        $deliveryAddressDAO->createDeliveryAddress($customerId, $address, $postcodeId, $order->getOrderId()); 

    }

    public function getDeliveryPostcode(int $postcodeId) : Postcode
    {
        $postcodeDAO = new PostcodeDAO;
        $postcode = $postcodeDAO->findPostcode($postcodeId);
        return $postcode;
    }

    public function getAllDeliveryAddresses() : array
    {
        $postcodeDAO = new PostcodeDAO;
        $postcodes = $postcodeDAO->findAll();
        return $postcodes;
    }

    public function createDeliveryAddress(int $customerId, string $address, int $postcodeId) : DeliveryAddress
    {
	$deliveryAddress = new DeliveryAddress($customerId, $address, $postcodeId, null);
	   
        return $deliveryAddress;
    }

    public function checkDeliveryIsPossible($postcode) : bool
    {
        switch ($postcode) {
            case '9000':
            case '9050':
            case '9031':
            case '9040':
            case '9041':
                return true;
            default:
    
                return false;
        }
    }
}
