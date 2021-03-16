<?php
declare(strict_types=1);

require_once __DIR__.'/../../../../config/Config.php';

class OrderItemDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function createOrderItem(int $orderId, int $productId)
    {
        $sql = <<< eof
        insert into OrderItem(orderId, productId) 
        values(:orderId, :productId)
        eof;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':orderId', $orderId);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
    }
}