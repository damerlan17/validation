<?php

namespace Validation\Rules;

use app\Validator\AbstractValidator;

class Numeric extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть числом';

    public function rule(): bool
    {
        return is_numeric($this->value);
    }
}