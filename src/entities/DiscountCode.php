<?php
declare(strict_types=1);

class DiscountCode
{
    private int $discountCodeId;
    private string $title;
    private float $discountAmount;

    public function __construct(int $id, string $title, float $discount)
    {
        $this->discountCodeId = $id;
        $this->title = $title;
        $this->discountAmount = $discount;
    }

    public function getDiscountCodeId() : int
    {
        return $this->discountCodeId;
    }

    public function setDiscountCodeId(int $id) : void
    {
        $this->discountCodeId = $id;
    }

    public function getTitle($title) : string
    {
        return $this->title;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getDiscountAmount() : float
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount(float $discount) : void
    {
        $this->discountAmount = $discount;
    }
}