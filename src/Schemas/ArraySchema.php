<?php

namespace Hexlet\Code\Schemas;

class ArraySchema extends Schema
{
    public function __construct($checks = [], $checksArgs = [], $requiredValue = false)
    {
        $this->validators = [
            'required' => fn(array|null $array) => !is_array($array),
            'sizeof' => fn(array $array, int $size) => count($array) === $size,
        ];
        $this->checks = $checks;
        $this->checksArgs = $checksArgs;
        $this->requiredValue = $requiredValue;
    }

    public function required(): ArraySchema
    {
        $this->requiredValue = true;
        return $this;
    }

    public function sizeof(int $size): ArraySchema
    {
        $this->checks['sizeof'] = $this->validators['sizeof'];
        $this->checksArgs['sizeof'] = [$size];
        return $this;
    }

    public function isValid(array|null $value): bool
    {
        if ($this->requiredValue && $this->validators['required']($value)) {
            return false;
        }

        foreach ($this->checks as $nameValidator => $validatorFn) {
            $isValid = $this->requiredValue = $validatorFn($value, ...$this->checksArgs[$nameValidator]);
            if (!$isValid) {
                return false;
            }
        }
        return true;
    }
}