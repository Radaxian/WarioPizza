<?php
declare(strict_types=1);

require_once __DIR__ . '/../data/CustomerDAO.php';
require_once __DIR__ . '/../data/PostcodeDAO.php';

class CustomerService
{
    public function registerCustomer(string $fname, string $sname, string $phone, string $address, string $postcode, ?string $email, ?string $password)
    {
        $customerDAO = new CustomerDAO;
        $id = $customerDAO->create($fname, $sname, $phone, $address, $postcode, $email, $password);
        return $id;
    }

    public function getCustomerById(int $id) : Customer
    {
        $customerDAO = new CustomerDAO;
        $customer = $customerDAO->findById($id);
        return $customer;
    }

    public function getCustomerDetails(string $email) : Customer
    {
        $customerDAO = new CustomerDAO;
        $customer = $customerDAO->findByEmail($email);
        return $customer;
    }

    public function getCustomerByAddress(string $address) : Customer
    {
        $customerDAO = new CustomerDAO;
        $customer = $customerDAO->findByAddress($address);
    
        return $customer;
    }

    public function checkPasswords(string $pwd1, string $pwd2) : bool
    {
        if (!($pwd1 === $pwd2)) {
            return false;
        }
        return true;
    }

    public function checkIfEmailExists(string $email) : bool
    {
        $customerDAO = new CustomerDAO;
        if ($customerDAO->findEmail($email)) {
            return true;
        }
        return false;
    }

    public function checkLoginDetails(string $email, string $password) : bool
    {
        $emailExists = $this->checkIfEmailExists($email);
        $passwordCorrect = $this->checkPasswordCorrect($email, $password);

        if ($emailExists && $passwordCorrect) {
            return true;
        }
        return false;
    }

    public function checkPasswordCorrect($email, $password) : bool
    {
        $hash = $this->getCustomerPassword($email);
        
        return password_verify($password, $hash);

    }

    private function getCustomerPassword(string $email) : string
    {
        $customerDAO = new CustomerDAO;
        $password = $customerDAO->findCustomerPassword($email);
        return $password;
    }

    public function getCustomerPostcode(int $postcodeId) : Postcode
    {
        $postcodeDAO = new postcodeDAO;
        $postcode = $postcodeDAO->findPostcode($postcodeId);
        return $postcode;
    }
}