<?php

namespace App\Utils\Traits;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Modules\Api\Errors\DomainValidationError;

trait HasValidator
{
    protected DomainValidationError $validator;

    public function validator(): DomainValidationError
    {
        return new DomainValidationError(
            ValidatorFacade::make([], [])
        );
    }
}
