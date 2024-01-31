<?php

namespace Hexlet\Code\Tests;

use Hexlet\Schemas\NumberSchema;
use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class NumberSchemaTest extends TestCase
{
    private NumberSchema $numberSchema;

    public function setUp(): void
    {
        $validator = new Validator();
        $this->numberSchema = $validator->number();
    }

    public function testPositiveTrue()
    {
        $result = $this->numberSchema->positive()->isValid(10);
        $this->assertTrue($result);
    }

    public function testPositiveTrueWithNull()
    {
        $result = $this->numberSchema->positive()->isValid(null);
        $this->assertTrue($result);
    }

    public function testPositiveFalse()
    {
        $result = $this->numberSchema->positive()->isValid(-10);
        $this->assertFalse($result);
    }

    public function testRangeTrue(): void
    {
        $result = $this->numberSchema->range(-5, 5)->isValid(5);
        $this->assertTrue($result);
    }

    public function testRangeFalse(): void
    {
        $result = $this->numberSchema->range(-5, 5)->isValid(-10);
        $this->assertFalse($result);
    }

    public function testIsValidTrue(): void
    {
        $result = $this->numberSchema->isValid(0);
        $this->assertTrue($result);
    }

    public function testIsValidTrueWithInt(): void
    {
        $result = $this->numberSchema->isValid(1);
        $this->assertTrue($result);
    }

    public function testIsValidFalseWithZero(): void
    {
        $result = $this->numberSchema->required()->isValid(0);
        $this->assertFalse($result);
    }

    public function testIsValidFalse(): void
    {
        $result = $this->numberSchema->required()->isValid(null);
        $this->assertFalse($result);
    }

    public function testMultipleCallTrue(): void
    {
        $result = $this->numberSchema->positive()->range(-5, 5)->isValid(5);
        $this->assertTrue($result);
    }

    public function testMultipleCallFalse(): void
    {
        $result = $this->numberSchema->positive()->range(-5, 5)->isValid(-3);
        $this->assertFalse($result);
    }
}