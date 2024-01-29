<?php

namespace Hexlet\Code;

use Hexlet\Code\Schemas\StringSchema;

class Validator
{
    public function string(): StringSchema
    {
        return new StringSchema();
    }
}