<?php

namespace Hexlet\Code\Tests;

use Hexlet\Code\Schemas\ArraySchema;
use Hexlet\Code\Validator;
use PHPUnit\Framework\TestCase;

class ArraySchemaTest extends TestCase
{
    private ArraySchema $arraySchema;

    public function setUp(): void
    {
        $validator = new Validator();
        $this->arraySchema = $validator->array();
    }

    public function testRequiredTrue(): void
    {
        $result = $this->arraySchema->required()->isValid([]);
        $this->assertTrue($result);
    }

    public function testRequiredFalse(): void
    {
        $result = $this->arraySchema->required()->isValid(null);
        $this->assertFalse($result);
    }

    public function testRequiredDefault(): void
    {
        $result = $this->arraySchema->isValid(null);
        $this->assertTrue($result);
    }

    public function testSizeOfTrue(): void
    {
        $result = $this->arraySchema->sizeof(2)->isValid([1, 'two']);
        $this->assertTrue($result);
    }

    public function testSizeOfFalse(): void
    {
        $result = $this->arraySchema->sizeof(2)->isValid(['two']);
        $this->assertFalse($result);
    }

    public function testMultipleCallTrue(): void
    {
        $result = $this->arraySchema->required()->sizeof(2)->isValid(['one', 'two']);
        $this->assertTrue($result);
    }

    public function testMultipleCallFalse(): void
    {
        $result = $this->arraySchema->required()->sizeof(2)->isValid(['one']);
        $this->assertFalse($result);
    }

    public function testNestedValidationTrue(): void
    {
        $validator = new Validator();
        $result = $this->arraySchema->shape([
            'name' =>  $validator->string()->required(),
            'age' =>  $validator->number()->positive(),
            ])
            ->isValid(['name' => 'kolya', 'age' => 100]);
        $this->assertTrue($result);
    }

    public function testNestedValidationFalse(): void
    {
        $validator = new Validator();
        $result = $this->arraySchema->shape([
            'name' =>  $validator->string()->required(),
            'age' =>  $validator->number()->positive(),
        ])
            ->isValid(['name' => 'ada', 'age' => -5]);
        $this->assertFalse($result);
    }

}