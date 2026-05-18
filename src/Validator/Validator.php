<?php

namespace Validation\Validator;

class Validator
{
    private array $validators = [];
    private array $errors = [];
    private array $fields = [];
    private array $rules = [];
    private array $messages = [];

    public function __construct(array $fields, array $rules, array $messages = [], array $customValidators = [])
    {
        $this->validators = array_merge($this->getDefaultValidators(), $customValidators);
        $this->fields = $fields;
        $this->rules = $rules;
        $this->messages = $messages;
        $this->validate();
    }

    protected function getDefaultValidators(): array
    {
        return [
            'required' => \Validation\Rules\Required::class,
            'unique'   => \Validation\Rules\Unique::class,
            'numeric'  => \Validation\Rules\Numeric::class,
            'min'      => \Validation\Rules\Min::class,
            'max'      => \Validation\Rules\Max::class,
            'exists'   => \Validation\Rules\Exists::class,
            'date_format' => \Validation\Rules\DateFormat::class,
        ];
    }

    private function validate(): void
    {
        foreach ($this->rules as $fieldName => $fieldValidators) {
            $this->validateField($fieldName, $fieldValidators);
        }
    }

    private function validateField(string $fieldName, array $fieldValidators): void
    {
        foreach ($fieldValidators as $validatorName) {
            $tmp = explode(':', $validatorName);
            [$validatorName, $args] = count($tmp) > 1 ? $tmp : [$validatorName, null];
            $args = isset($args) ? explode(',', $args) : [];

            $validatorClass = $this->validators[$validatorName] ?? null;
            if (!$validatorClass || !class_exists($validatorClass)) {
                continue;
            }

            $validator = new $validatorClass(
                $fieldName,
                $this->fields[$fieldName] ?? null,
                $args,
                $this->messages[$validatorName] ?? null
            );

            if ($validator->validate() !== true) {
                $this->errors[$fieldName][] = $validator->validate();
            }
        }
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function fails(): bool
    {
        return (bool)count($this->errors);
    }
}