<?php

namespace Hexlet\Code\Tests;

use Hexlet\Code\Schemas\NumberSchema;
use Hexlet\Code\Validator;
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
        $result = $this->numberSchema->isValid(null);
        $this->assertTrue($result);
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