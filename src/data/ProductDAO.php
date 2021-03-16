<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../config/Config.php';
require_once __DIR__ . '/../entities/Product.php';

class ProductDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function findAll() : array
    {
        $sql = 'select * from Product';

        $products = [];

        foreach ($this->pdo->query($sql) as $row) {
            list($id, $title, $description, $price, $image, $discount) = $row;
            $product = new Product((int) $id, $title, $description, (float) $price, $image, (float) $discount);
            $products[] = $product;
        }

        return $products;

    }

    public function findById(int $id) : Product
    {
        $sql = 'select * from Product where productId = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        list($id, $title, $description, $price, $image, $discount) = $stmt->fetch();
        $product = new Product((int) $id, $title, $description, (float) $price, $image, (float) $discount);

        return $product;
    }

}