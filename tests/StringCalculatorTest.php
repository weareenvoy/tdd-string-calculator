<?php

use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{
    /**
     * @test
     */
    public function sums_an_empty_string()
    {
        $calc = $this->createCalculator();

        $result = $calc->add('');

        self::assertSame(0, $result);
    }

    /**
     * @test
     */
    public function sums_string_with_one_number()
    {
        $calc = $this->createCalculator();

        $result = $calc->add('1');

        self::assertSame(1, $result);
    }

    /**
     * @return StringCalculator
     */
    private function createCalculator(): StringCalculator
    {
        return new StringCalculator;
    }
}
