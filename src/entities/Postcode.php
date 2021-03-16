<?php
declare(strict_types=1);

class Postcode
{
    private int $postcodeId;
    private ?string $postcode;
    private ?string $area;

    public function __construct(int $postcodeId, ?string $postcode, ?string $area)
    {
        $this->postcodeId = $postcodeId;
        $this->postcode = $postcode;
        $this->area = $area;
    }

    public function getPostcodeId() : int
    {
        return $this->postcodeId;
    }

    public function setPostcodeId(int $id) : void
    {
        $this->postcodeId = $id;
    }

    public function getPostcode() : ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode) : void
    {
        $this->postcode = $postcode;
    }

    public function getArea() : string
    {
        return $this->area;
    }

    public function setArea(string $area) : void
    {
        $this->area = $area;
    }
}