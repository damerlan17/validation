<?php

namespace Validation\Rules;

use app\Validator\AbstractValidator;

class Required extends AbstractValidator
{
    protected string $message = 'Поле :field обязательно для заполнения';

    public function rule(): bool
    {
        return !empty($this->value);
    }
}