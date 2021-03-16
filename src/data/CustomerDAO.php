<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../config/Config.php';
require_once __DIR__ . '/../entities/Customer.php';

class CustomerDAO 
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.Config::$DBHOST.';dbname='.Config::$DBNAME.';charset=utf8', Config::$DBUSER, Config::$DBPWD);
    }

    public function create(string $fname, string $sname, string $phone, string $address, string $postcode, ?string $email, ?string $password)
    {
        $sql = <<< eof
        insert into Customer(firstname, surname, phone, address, email, password, postcodeId, discountCodeId) 
        values (:fname, :sname, :phone, :address, :email, :password, (select postcodeId from Postcode where postcode = :postcode),1)
        eof;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':sname', $sname);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->execute();
        $id = $this->pdo->lastInsertId(); // id is required for wen the customer does not register an email
        return $id;
    }

    public function findById(int $id) : Customer
    {
        $sql = 'select * from Customer where customerId = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        list($id, $fname, $sname, $phone, $address, $email, $password, $postCodeId, $discountCodeId) = $stmt->fetch();
        $customer = new Customer((int) $id, $fname, $sname, $phone, $address, $email, $password, (int) $postCodeId, (int) $discountCodeId);
        return $customer;
    }

    public function findByEmail(string $email) : Customer
    {
        $sql = 'select * from Customer where email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        list($id, $fname, $sname, $phone, $address, $email, $password, $postCodeId, $discountCodeId) = $stmt->fetch();
        $customer = new Customer((int) $id, $fname, $sname, $phone, $address, $email, $password, (int) $postCodeId, (int) $discountCodeId);
        return $customer;
    }

    public function findByAddress(string $address) : Customer
    {
        $sql = 'select * from Customer where address = :address';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->execute();

        list($id, $fname, $sname, $phone, $address, $email, $password, $postCodeId, $discountCodeId) = $stmt->fetch();
        $customer = new Customer((int) $id, $fname, $sname, $phone, $address, $email, $password, (int) $postCodeId, (int) $discountCodeId);
        return $customer;
    }

    public function findEmail(string $email) : ?string
    {
        $sql = 'select email from Customer where email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        list($email) = $stmt->fetch();

        return $email;
    }

    public function findCustomerPassword(string $email) : string
    {
        $sql = 'select password from Customer where email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        list($password) = $stmt->fetch();

        return $password;
    }

}