<?php

declare(strict_types=1);

namespace JGI\Ratsit\Event;

use JGI\Ratsit\Model\Person;
use Symfony\Contracts\EventDispatcher\Event;

class PersonInformationResultEvent extends Event
{
    const NAME = 'ratsit.person_information_result';

    /**
     * @var Person
     */
    private $person;

    /**
     * @param Person $person
     */
    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }
}
