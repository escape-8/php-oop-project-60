<?php

namespace Hexlet\Validator;

use Hexlet\Schemas\ArraySchema;
use Hexlet\Schemas\NumberSchema;
use Hexlet\Schemas\StringSchema;

class Validator
{
    private array $userValidators = [];
    public function string(): StringSchema
    {
        $stringUserValidators = $this->userValidators['string'] ?? [];
        return new StringSchema($stringUserValidators);
    }

    public function number(): NumberSchema
    {
        $numberUserValidators = $this->userValidators['number'] ?? [];
        return new NumberSchema($numberUserValidators);
    }

    public function array(): ArraySchema
    {
        $arrayUserValidators = $this->userValidators['array'] ?? [];
        return new ArraySchema($arrayUserValidators);
    }

    public function addValidator(string $type, string $name, callable $fn): void
    {
        if (!method_exists($this, $type)) {
            throw new \InvalidArgumentException('Type of validator ' . $type . ' does not exists');
        }
        $this->userValidators[$type][$name] = $fn;
    }
}
