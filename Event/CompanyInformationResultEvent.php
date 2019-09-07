<?php

declare(strict_types=1);

namespace JGI\Ratsit\Event;

use JGI\Ratsit\Model\Company;
use Symfony\Component\EventDispatcher\Event;

class CompanyInformationResultEvent extends Event
{
    const NAME = 'ratsit.company_information_result';

    /**
     * @var Company
     */
    private $company;

    /**
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }
}
