<?php

declare(strict_types=1);

namespace JGI\Ratsit;

use JGI\Ratsit\Exception\InvalidJsonException;
use JGI\Ratsit\Model\Address;
use JGI\Ratsit\Model\Person;
use JGI\Ratsit\Model\SearchResult;

class Denormalizer
{
    /**
     * @param array|null $data
     *
     * @return Person
     */
    public function denormalizerPersonInformation(?array $data)
    {
        if (!$data || !array_key_exists('basic', $data)) {
            throw new InvalidJsonException();
        }

        $person = new Person();
        $person->setFirstName($data['basic']['firstName']);
        $person->setGivenName($data['basic']['givenName']);
        $person->setSurName($data['basic']['surName']);
        $person->setMiddleName($data['basic']['middleName']);
        $person->setLastName($data['basic']['lastName']);
        $address = new Address();
        $address->setStreet($data['basic']['street']);
        $address->setCo($data['basic']['co']);
        $address->setPostalCode($data['basic']['zipCode']);
        $address->setCity($data['basic']['city']);
        $person->setAddress($address);
        $person->setPhoneNumbers($data['phoneNumbers']['phoneNumbers']);

        return $person;
    }
    /**
     * @param array|null $data
     *
     * @return SearchResult|Person[]
     */
    public function denormalizerPersonSearch(?array $data)
    {
        if (!$data || !array_key_exists('extendedResult', $data)) {
            throw new InvalidJsonException();
        }

        $persons = new SearchResult();
        $persons->setTotalRecordsFound($data['extendedResult']['totalRecordsFound']);
        foreach ($data['extendedResult']['records'] as $row) {
            $person = new Person();
            $person->setSocialSecurityNumber($row['ssn']);
            $person->setFirstName($row['firstName']);
            $person->setGivenName($row['givenName']);
            $person->setLastName($row['lastName']);
            $address = new Address();
            $address->setStreet($row['street']);
            $address->setPostalCode($row['zipCode']);
            $address->setCity($row['city']);
            $person->setAddress($address);
            if (array_key_exists('phoneNumbers', $row)) { // Ratsit only return phone numbers if only one person is found
                $person->setPhoneNumbers($row['phoneNumbers']);
            }
            $persons->add($person);
        }

        return $persons;
    }
}
