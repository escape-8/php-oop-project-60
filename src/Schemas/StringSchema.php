<?php

namespace Hexlet\Code\Schemas;

class StringSchema extends Schema
{
    public function __construct($validators = [], $checks = [], $checksArgs = [], $requiredValue = false)
    {
        $this->validators = array_merge([
            'required' => fn(string|null $string) => empty($string),
            'minLength' => fn(string $string, int $minLength) => strlen($string) >= $minLength,
            'contains' => fn(string $haystack, string $needle) => str_contains($haystack, $needle),
            ], $validators);
        $this->checks = $checks;
        $this->checksArgs = $checksArgs;
        $this->requiredValue = $requiredValue;
    }

    public function required(): StringSchema
    {
        $this->requiredValue = true;
        return $this;
    }

    public function minLength(int $minLength = 0): StringSchema
    {
        $this->checks['minLength'] = $this->validators['minLength'];
        $this->checksArgs['minLength'] = $minLength;
        return $this;
    }

    public function contains(string $needle = ''): StringSchema
    {
        $this->checks['contains'] = $this->validators['contains'];
        $this->checksArgs['contains'] = $needle;
        return $this;
    }

    public function isValid(string|null $value): bool
    {
        if ($this->requiredValue && $this->validators['required']($value)) {
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

    public function test(string $validatorName, string $arg): StringSchema
    {
        $this->checks[$validatorName] = $this->validators[$validatorName];
        $this->checksArgs[$validatorName] = [$arg];
        return $this;
    }
}
