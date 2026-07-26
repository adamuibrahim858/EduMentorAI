<?php

namespace App\Exceptions;

use RuntimeException;

class AccountDisabledException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Your EduMentor AI account is currently disabled. Please contact support if this looks wrong.');
    }
}
