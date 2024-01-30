<?php

namespace Hexlet\Code\Schemas;

class NumberSchema
{
    private array $validators;
    private array $checks;
    private array $checksArgs;
    private bool $requiredValue;

    public function __construct($checks = [], $checksArgs = [], $requiredValue = false)
    {
        $this->validators = [
            'required' => fn(int|null $integer) => $integer === null,
            'positive' => fn(int $integer) => $integer > 0,
            'range' => fn(int $integer, int $from, int $to) => ($integer >= $from) && ($integer <= $to),
        ];
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