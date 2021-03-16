<?php
declare(strict_types=1);

class OrderItem
{
    private int $itemId;
    private int $orderId;
    private int $productId;

    public function __construct(int $itemId, int $orderId, int $productId)
    {
        $this->itemId = $itemId;
        $this->orderId = $orderId;
        $this->productId = $productId;
    }

    public function getItemId() : int
    {
        return $this->itemId;
    }

    public function setItemId(int $id) : void
    {
        $this->itemId = $id;
    }

    public function getOrderId() : int
    {
        return $this->orderId;
    }

    public function setOrderId(int $id) : void
    {
        $this->orderId = $id;
    }

    public function getProductId() : int
    {
        return $this->productId;
    }

    public function setProductId(int $id) : void
    {
        $this->productId = $id;
    }
}