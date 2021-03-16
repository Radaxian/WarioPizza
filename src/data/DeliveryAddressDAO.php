<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../config/Config.php';
require_once __DIR__ . '/../entities/DeliveryAddress.php';

class DeliveryAddressDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function createDeliveryAddress(int $customerId, string $address, int $postcodeId, int $orderId)
    {
        $sql = 'insert into DeliveryAddress values(:customerId, :address, :postcodeId, :orderId)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':customerId', $customerId);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':postcodeId', $postcodeId);
        $stmt->bindParam(':orderId', $orderId);
	$stmt->execute();
	
    }

    public function findByCustomerId(int $id) : DeliveryAddress
    {
        $sql = 'select * from DeliveryAddress where customerId = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        list($customerId, $address, $postcodeId, $orderId) = $stmt->fetch();
        $deliveryAddress = new DeliveryAddress((int) $customerId, $address, (int) $postcodeId, (int) $orderId);
        return $deliveryAddress;

    }

    public function findByAddress(string $address) : DeliveryAddress
    {
        $sql = 'select * from DeliveryAddress where address = :address';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->execute();

        list($customerId, $address, $postcodeId, $orderId) = $stmt->fetch();
        $deliveryAddress = new DeliveryAddress((int) $customerId, $address, (int) $postcodeId, (int) $orderId);
        return $deliveryAddress;

    }
}
