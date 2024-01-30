<?php

namespace Hexlet\Code;

use Hexlet\Code\Schemas\ArraySchema;
use Hexlet\Code\Schemas\NumberSchema;
use Hexlet\Code\Schemas\StringSchema;

class Validator
{
    public function string(): StringSchema
    {
        return new StringSchema();
    }

    public function number(): NumberSchema
    {
        return new NumberSchema();
    }

    public function array(): ArraySchema
    {
        return new ArraySchema();
    }
}