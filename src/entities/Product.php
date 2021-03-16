<?php
declare(strict_types=1);

class Product
{
    private int $productId;
    private string $title;
    private string $description;
    private float $price;
    private string $image;
    private float $discount;

    public function __construct(int $productId, string $title, string $description, float $price, string $image, float $discount)
    {
        $this->productId = $productId;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->discount = $discount;
    }

    public function getProductId() : int
    {
        return $this->productId;
    }

    public function setProductId(int $id) : void
    {
        $this->productId = $id;
    }

    public function getTitle() : string
    {
        return $this->title;
    } 

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getPrice() : float
    {
        return $this->price;
    }

    public function setPrice(float $price) : void
    {
        $this->price = $price;
    }

    public function getImage() : string
    {
        return $this->image;
    }

    public function setImage(string $image) : void
    {
        $this->image = $image;
    }

    public function getDiscount() : float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount) : void
    {
        $this->discount = $discount;
    }

}