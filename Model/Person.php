<?php

declare(strict_types=1);

namespace JGI\Ratsit\Model;

class Person
{
    /**
     * @var string|null
     */
    private $firstName;

    /**
     * @var string|null
     */
    private $givenName;

    /**
     * @var string|null
     */
    private $surName;

    /**
     * @var string|null
     */
    private $middleName;

    /**
     * @var string|null
     */
    private $lastName;

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var string[]
     */
    private $phoneNumbers = [];

    /**
     * @var string|null
     */
    private $socialSecurityNumber;

    /**
     * @var \DateTimeImmutable|null
     */
    private $birthDate;

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param null|string $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return null|string
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * @param null|string $givenName
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * @return null|string
     */
    public function getSurName(): ?string
    {
        return $this->surName;
    }

    /**
     * @param null|string $surName
     */
    public function setSurName(?string $surName): void
    {
        $this->surName = $surName;
    }

    /**
     * @return null|string
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param null|string $middleName
     */
    public function setMiddleName(?string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string[]
     */
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }

    /**
     * @param string[] $phoneNumbers
     */
    public function setPhoneNumbers(array $phoneNumbers): void
    {
        $this->phoneNumbers = $phoneNumbers;
    }

    /**
     * @return null|string
     */
    public function getSocialSecurityNumber(): ?string
    {
        return $this->socialSecurityNumber;
    }

    /**
     * @param null|string $socialSecurityNumber
     */
    public function setSocialSecurityNumber(?string $socialSecurityNumber): void
    {
        $this->socialSecurityNumber = $socialSecurityNumber;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTimeImmutable|null $birthDate
     */
    public function setBirthDate(?\DateTimeImmutable $birthDate): void
    {
        $this->birthDate = $birthDate;
    }
}
