<?php

namespace Hexlet\Schemas;

abstract class Schema
{
    protected array $validators;
    protected array $checks;
    protected array $checksArgs;
    protected bool $requiredValue;

    abstract public function __construct($validators = [], $checks = [], $checksArgs = [], $requiredValue = false);
}
