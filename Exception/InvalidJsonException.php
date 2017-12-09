<?php

declare(strict_types=1);

namespace JGI\Ratsit\Exception;

class InvalidJsonException extends \RuntimeException
{
    public function __construct($message = 'Provided json is invalid')
    {
        parent::__construct($message);
    }

}
