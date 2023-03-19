<?php

declare(strict_types=1);

namespace Support\ValueObjects;


use InvalidArgumentException;
use Tests\TestCase;

final class PriceTest extends TestCase
{
    public function test_all_values(): void
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(100, $price->value());
        $this->assertEquals(10000, $price->raw());
        $this->assertEquals('UAH', $price->currency());
        $this->assertEquals('₴', $price->symbol());
        $this->assertEquals('100,00 ₴', $price);

        $this->expectException(InvalidArgumentException::class);

        Price::make(-10000);
        Price::make(10000, 'USD');
    }
}
