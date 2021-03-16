<?php
declare(strict_types=1);

class CustomerOrder
{
    private int $orderId;
    private int $customerId;
    private string $orderDate;
    private float $total;
    private float $discount;

    public function __construct(int $id, int $customerId, string $orderDate, float $total, float $discount)
    {
        $this->orderId = $id;
        $this->customerId = $customerId;
        $this->orderDate = $orderDate;
        $this->total = $total;
        $this->discount = $discount;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }

    public function setOrderId(int $id) : void
    {
        $this->orderId = $id;
    }

    public function getCustomerId() : int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $id) : void
    {
        $this->customerId = $id;
    }

    public function getOrderDate() : string
    {
        return $this->orderDate;
    }

    public function setOrderDate(string $orderDate) : void
    {
        $this->orderDate = $orderDate;
    }

    public function getTotal() : float
    {
        return $this->total;
    }

    public function setTotal(float $total) : void
    {
        $this->total = $total;
    }

    public function getDiscount() : float
    {
        return $this->discount;
    }

    public function setDiscount($discount) : void
    {
        $this->discount = $discount;
    }

}