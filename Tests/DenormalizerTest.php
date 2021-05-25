<?php

declare(strict_types=1);

namespace JGI\Ratsit\Tests;

use JGI\Ratsit\Denormalizer;
use JGI\Ratsit\Model\Address;
use JGI\Ratsit\Model\Person;
use JGI\Ratsit\Model\Company;
use JGI\Ratsit\Model\SearchResult;
use PHPUnit\Framework\TestCase;

class DenormalizerTest extends TestCase
{
    /**
     * @var Denormalizer
     */
    private $denormalizer;

    public function setUp()
    {
        $this->denormalizer = new Denormalizer();
    }

    /**
     * @test
     */
    public function shouldDenormalizePersonInformation()
    {
        $person = $this->denormalizer->denormalizerPersonInformation(
            json_decode(file_get_contents(__DIR__ . '/personInformation.json'), true)
        );

        $this->assertInstanceOf(Person::class, $person);
        $this->assertEquals('Per Fredrik', $person->getFirstName());
        $this->assertEquals('Per', $person->getGivenName());
        $this->assertEquals('Hedlund', $person->getSurName());
        $this->assertEquals('H', $person->getMiddleName());
        $this->assertEquals('Hedlund', $person->getLastName());
        $this->assertInstanceOf(Address::class, $person->getAddress());
        $this->assertEquals('Åkervägen 2 lgh 1202', $person->getAddress()->getStreet());
        $this->assertEquals('co', $person->getAddress()->getCo());
        $this->assertEquals('26051', $person->getAddress()->getPostalCode());
        $this->assertEquals('EKEBY', $person->getAddress()->getCity());
        $this->assertEquals(9, count($person->getPhoneNumbers()));
        $this->assertEquals('070-4107021', $person->getPhoneNumbers()[0]);
    }

    /**
     * @test
     */
    public function shouldReturnNullIfPersonInformationWasNotFound()
    {
        $person = $this->denormalizer->denormalizerPersonInformation(
            json_decode(file_get_contents(__DIR__ . '/noPersonInformationFound.json'), true)
        );

        $this->assertNull($person);
    }

    /**
     * @test
     */
    public function shouldReturnNullIfIdentityNumberIsInvalid()
    {
        $person = $this->denormalizer->denormalizerPersonInformation(
            json_decode(file_get_contents(__DIR__ . '/invalidIdentityNumber.json'), true)
        );

        $this->assertNull($person);
    }

    /**
     * @test
     */
    public function shouldDenormalizePersonSearch()
    {
        $persons = $this->denormalizer->denormalizerPersonSearch(
            json_decode(file_get_contents(__DIR__ . '/personSearch.json'), true)
        );

        $this->assertInstanceOf(SearchResult::class, $persons);
        $this->assertEquals(1, count($persons));
        /** @var Person $person */
        $person = $persons->first();
        $this->assertEquals('194107081111', $person->getSocialSecurityNumber());
        $this->assertEquals('Per Fredrik', $person->getFirstName());
        $this->assertEquals('Per', $person->getGivenName());
        $this->assertNull($person->getSurName());
        $this->assertNull($person->getMiddleName());
        $this->assertEquals('Hedlund', $person->getLastName());
        $this->assertInstanceOf(Address::class, $person->getAddress());
        $this->assertEquals('Åkervägen 2 lgh 1202', $person->getAddress()->getStreet());
        $this->assertNull($person->getAddress()->getCo());
        $this->assertEquals('26051', $person->getAddress()->getPostalCode());
        $this->assertEquals('EKEBY', $person->getAddress()->getCity());
        $this->assertEquals(9, count($person->getPhoneNumbers()));
        $this->assertEquals('070-4107021', $person->getPhoneNumbers()[0]);
        $this->assertNull($person->getBirthDate());
    }

    /**
     * @test
     * @dataProvider invalidPersonProvider
     * @expectedException \JGI\Ratsit\Exception\InvalidJsonException
     * @expectedExceptionMessage Provided json is invalid
     */
    public function shouldThrowExceptionIfPersonInformationFormatIsNotCorrect($data)
    {
        $this->denormalizer->denormalizerPersonInformation($data);
    }

    /**
     * @test
     * @dataProvider invalidPersonProvider
     * @expectedException \JGI\Ratsit\Exception\InvalidJsonException
     * @expectedExceptionMessage Provided json is invalid
     */
    public function shouldThrowExceptionIfPersonSearchFormatIsNotCorrect($data)
    {
        $this->denormalizer->denormalizerPersonSearch($data);
    }

    /**
     * @return array
     */
    public function invalidPersonProvider()
    {
        return [
            [['']],
            [null],
            [[]],
            [['foo' => 'bar']],
        ];
    }

    /**
     * @test
     */
    public function shouldDenormalizeCompanyInformation()
    {
        $company = $this->denormalizer->denormalizerCompanyInformation(
            json_decode(file_get_contents(__DIR__ . '/companyInformation.json'), true)
        );

        $this->assertInstanceOf(Company::class, $company);
        $this->assertEquals('Aktiebolaget Gense', $company->getName());
        $this->assertInstanceOf(Address::class, $company->getAddress());
        $this->assertEquals('BOX 1115', $company->getAddress()->getStreet());
        $this->assertEquals('co', $company->getAddress()->getCo());
        $this->assertEquals('63180', $company->getAddress()->getPostalCode());
        $this->assertEquals('ESKILSTUNA', $company->getAddress()->getCity());
        $this->assertEquals('016-159000', $company->getPhoneNumber());
    }
}
