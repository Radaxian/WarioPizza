<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../config/Config.php';
require_once __DIR__ . '/../entities/CustomerOrder.php';

class CustomerOrderDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function createCustomerOrder(int $customerId, string $dateTime, $total, $discount)
    { 
        $sql = <<< eof
        insert into CustomerOrder(
            customerId, orderDate, total, discount) 
            values(:customerId, :dateTime, :total, :discount)
        eof;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->bindParam(':dateTime', $dateTime);
        $stmt->bindParam(':total', $total);
        $stmt->bindParam(':discount', $discount);
        $stmt->execute();
    }

    public function findOrderByDateTime($dateTime) : CustomerOrder
    { 
        $sql = 'select * from CustomerOrder where orderDate = :dt';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':dt', $dateTime);
        $stmt->execute();

        list($id, $customerId, $orderDate, $total, $discount) = $stmt->fetch();
        $order = new CustomerOrder((int) $id, (int) $customerId, $orderDate, (float) $total, (float) $discount);
        return $order;
    }

}