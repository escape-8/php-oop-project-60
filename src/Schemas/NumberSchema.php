<?php

namespace Hexlet\Schemas;

class NumberSchema extends Schema
{
    public function __construct($validators = [], $checks = [], $checksArgs = [], $requiredValue = false)
    {
        $this->validators = array_merge([
            'required' => fn(int|null $integer) => $integer === null,
            'positive' => fn(int|null $integer) => $integer >= 0,
            'range' => fn(int|null $integer, int $from, int $to) => ($integer >= $from) && ($integer <= $to),
        ], $validators);
        $this->checks = $checks;
        $this->checksArgs = $checksArgs;
        $this->requiredValue = $requiredValue;
    }

    public function required(): NumberSchema
    {
        $this->requiredValue = true;
        return $this;
    }

    public function positive(): NumberSchema
    {
        $this->checks['positive'] = $this->validators['positive'];
        $this->checksArgs['positive'] = [];
        return $this;
    }

    public function range(int $from, int $to): NumberSchema
    {
        $this->checks['range'] = $this->validators['range'];
        $this->checksArgs['range'] = [$from, $to];
        return $this;
    }

    public function isValid($value): bool
    {
        if (($value === 0) || ($this->requiredValue && $this->validators['required']($value))) {
            return false;
        }

        foreach ($this->checks as $nameValidator => $validatorFn) {
            $isValid = $validatorFn($value, ...$this->checksArgs[$nameValidator]);
            if (!$isValid) {
                return false;
            }
        }
        return true;
    }

    public function test(string $validatorName, string $arg): NumberSchema
    {
        $this->checks[$validatorName] = $this->validators[$validatorName];
        $this->checksArgs[$validatorName] = [$arg];
        return $this;
    }
}
