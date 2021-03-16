<?php
declare(strict_types=1);

class DeliveryAddress
{
    private int $customerId;
    private string $address;
    private int $postcodeId;
    private ?int $orderId;

    public function __construct(int $customerId, string $address, int $postcodeId, ?int $orderId)
    {
        $this->customerId = $customerId;
        $this->address = $address;
        $this->postcodeId = $postcodeId;
        $this->orderId = $orderId;
    }

    public function getCustomerId() : int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $id) : void
    {
        $this->customerId = $id;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getPostcodeId() : int
    {
        return $this->postcodeId;
    }

    public function setPostcodeId(int $id) : void
    {
        $this->postcodeId = $id;
    }

    public function getOrderId() : ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $id) : void
    {
        $this->orderId = $id;
    }
}