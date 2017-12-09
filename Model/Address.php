<?php

declare(strict_types=1);

namespace JGI\Ratsit\Model;

class Address
{
    /**
     * @var string|null
     */
    private $street;

    /**
     * @var string|null
     */
    private $co;

    /**
     * @var string|null
     */
    private $postalCode;

    /**
     * @var string|null
     */
    private $city;

    /**
     * @return null|string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param null|string $street
     */
    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return null|string
     */
    public function getCo(): ?string
    {
        return $this->co;
    }

    /**
     * @param null|string $co
     */
    public function setCo(?string $co): void
    {
        $this->co = $co;
    }

    /**
     * @return null|string
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param null|string $postalCode
     */
    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }
}
