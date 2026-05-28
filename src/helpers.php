<?php

namespace Validation;

use Validation\Validator\Validator;

function validator(array $data, array $rules, array $messages = [], array $customValidators = []): Validator
{
    return new Validator($data, $rules, $messages, $customValidators);
}