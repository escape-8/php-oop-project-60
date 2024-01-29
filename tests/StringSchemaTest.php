<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\Validator;
use Hexlet\Code\Schemas\StringSchema;

class StringSchemaTest extends TestCase
{
    private StringSchema $stringSchema;

    public function setUp(): void
    {
        $validator = new Validator();
        $this->stringSchema = $validator->string();
    }

    public function testRequiredDefault(): void
    {
        $result = $this->stringSchema->isValid('');
        $this->assertTrue($result);
    }

    public function testRequiredTrue(): void
    {
        $result = $this->stringSchema->required()->isValid('tested');
        $this->assertTrue($result);
    }

    public function testRequiredFalse(): void
    {
        $result = $this->stringSchema->required()->isValid(null);
        $this->assertFalse($result);
    }

    public function testMinLengthTrue(): void
    {
        $result = $this->stringSchema->minLength(5)->isValid('Tested');
        $this->assertTrue($result);
    }

    public function testMinLengthFalse(): void
    {
        $result = $this->stringSchema->minLength(5)->isValid('Hex');
        $this->assertFalse($result);
    }

    public function testMinLengthDefault(): void
    {
        $result = $this->stringSchema->minLength()->isValid('');
        $this->assertTrue($result);
    }

    public function testContainsTrue(): void
    {
        $result = $this->stringSchema->contains('what')->isValid('what does the fox say');
        $this->assertTrue($result);
    }

    public function testContainsFalse(): void
    {
        $result = $this->stringSchema->contains('whatthe')->isValid('what does the fox say');
        $this->assertFalse($result);
    }

    public function testContainsDefault(): void
    {
        $result = $this->stringSchema->contains('')->isValid('what does the fox say');
        $this->assertTrue($result);
    }

    public function testMultipleCall()
    {
        $result = $this->stringSchema->minLength(10)->minLength(5)->isValid('Tested');
        $this->assertTrue($result);
    }
}