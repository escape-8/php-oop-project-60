<?php

namespace Hexlet\Code\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private Validator $validator;
    public function setUp(): void
    {
        $this->validator = new Validator();
    }

    public function testAddValidatorInStringSchemaTrue(): void
    {
        $fn = fn($value, $start) => str_starts_with($value, $start);
        $this->validator->addValidator('string', 'startWith', $fn);
        $result = $this->validator->string()->test('startWith', 'H')->isValid('Hexlet');
        $this->assertTrue($result);
    }

    public function testAddValidatorInStringSchemaFalse(): void
    {
        $fn = fn($value, $start) => str_starts_with($value, $start);
        $this->validator->addValidator('string', 'startWith', $fn);
        $result = $this->validator->string()->test('startWith', 'H')->isValid('exlet');
        $this->assertFalse($result);
    }

    public function testInvalidAddValidatorInStringSchema(): void
    {
        $fn = fn($value, $start) => str_starts_with($value, $start);
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->addValidator('wrong-type', 'startWith', $fn);
    }

    public function testAddValidatorInNumberSchemaTrue(): void
    {
        $fn = fn($value, $min) => $value >= $min;
        $this->validator->addValidator('number', 'min', $fn);
        $result = $this->validator->number()->test('min', 5)->isValid(6);
        $this->assertTrue($result);
    }

    public function testAddValidatorInNumberSchemaFalse(): void
    {
        $fn = fn($value, $min) => $value >= $min;
        $this->validator->addValidator('number', 'min', $fn);
        $result = $this->validator->number()->test('min', 5)->isValid(4);
        $this->assertFalse($result);
    }

    public function testInvalidAddValidatorInNumberSchema(): void
    {
        $fn = fn($value, $min) => $value >= $min;
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->addValidator('number-type', 'min', $fn);
    }

    public function testAddValidatorInArraySchemaTrue(): void
    {
        $fn = fn($value, $min) => count($value) >= $min;
        $this->validator->addValidator('array', 'min', $fn);
        $result = $this->validator->array()->test('min', 2)
            ->isValid(['key1' => 'val1', 'key2' => 'val2']);
        $this->assertTrue($result);
    }

    public function testAddValidatorInArraySchemaFalse(): void
    {
        $fn = fn($value, $min) => count($value) >= $min;
        $this->validator->addValidator('array', 'min', $fn);
        $result = $this->validator->array()->test('min', 2)
            ->isValid(['key1' => 'val1']);
        $this->assertFalse($result);
    }

    public function testInvalidAddValidatorInArraySchema(): void
    {
        $fn = fn($value, $min) => count($value) >= $min;
        $this->expectException(\InvalidArgumentException::class);
        $this->validator->addValidator('array-type', 'min', $fn);
    }
}