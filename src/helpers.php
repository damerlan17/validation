<?php

namespace Validation;

use app\Validator\Validator;

if (!function_exists('Validation\\validator')) {
    function validator(array $data, array $rules, array $messages = [], array $customValidators = []): Validator
    {
        return new Validator($data, $rules, $messages, $customValidators);
    }
}