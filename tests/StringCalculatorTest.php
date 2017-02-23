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
     * @test
     */
    public function sums_string_with_two_numbers()
    {
        $calc = $this->createCalculator();

        $result = $calc->add('1,2');

        self::assertSame(3, $result);
    }

    /**
     * @test
     */
    public function sums_string_with_many_numbers()
    {
        $calc = $this->createCalculator();

        $result1 = $calc->add('1,2,3,4,5'); // 15
        $result2 = $calc->add('4,9,16,25,36,49,64,81,100'); // 384

        self::assertSame(15, $result1);
        self::assertSame(384, $result2);
    }

    /**
     * @return StringCalculator
     */
    private function createCalculator(): StringCalculator
    {
        return new StringCalculator;
    }
}
