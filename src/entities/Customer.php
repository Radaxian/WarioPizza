<?php
declare(strict_types=1);

class Customer
{
    private int $customerId;
    private string $firstname;
    private string $surname;
    private string $phone;
    private string $address;
    private ?string $email;
    private ?string $password;
    private int $postcodeId;
    private int $discountCodeId;

    public function __construct(int $id, string $fname, string $sname, string $phone, string $address, ?string $email, ?string $pwd, int $postcodeId, int $discountCodeId)
    {
        $this->customerId = $id;
        $this->firstname = $fname;
        $this->surname = $sname;
        $this->phone = $phone;
        $this->address = $address;
        $this->email = $email;
        $this->password = $pwd;
        $this->postcodeId = $postcodeId;
        $this->discountCodeId = $discountCodeId;
    }

    public function getCustomerId() : int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $id) : void
    {
        $this->customerId = $id;
    }

    public function getFirstname() : string
    {
        return $this->firstname;
    }

    public function setFirstname(string $fname) : void
    {
        $this->firstname = $fname;
    }

    public function getSurname() : string
    {
        return $this->surname;
    }

    public function setSurname(string $sname)
    {
        $this->surname = $sname;
    }

    public function getPhone() : string
    {
        return $this->phone;
    }

    public function setPhone(string $phone) : void
    {
        $this->phone = $phone;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $pwd) : void
    {
        $this->password = $pwd;
    }

    public function getPostcodeId() : int
    {
        return $this->postcodeId;
    }

    public function setPostcodeId(int $id) : void
    {
        $this->postcodeId = $id;
    }

    public function getDiscountCodeId() : int
    {
        return $this->discountCodeId;
    }

    public function setDiscountCodeId(int $id) : void
    {
        $this->discountCodeId = $id;
    }
}