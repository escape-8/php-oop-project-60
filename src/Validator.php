<?php

namespace Hexlet\Code;

use Hexlet\Code\Schemas\ArraySchema;
use Hexlet\Code\Schemas\NumberSchema;
use Hexlet\Code\Schemas\StringSchema;

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
