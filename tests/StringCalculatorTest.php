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
     * @test
     */
    public function sums_string_with_comma_and_newline_delimiters()
    {
        $calc = $this->createCalculator();

        $result1 = $calc->add("1\n2,3");
        $result2 = $calc->add("2,4,6\n8\n10\n12");
        $result3 = $calc->add("3\n6,9\n12,15\n18");
        $result4 = $calc->add("4\n16\n64\n256\n1024");

        self::assertSame(6, $result1);
        self::assertSame(42, $result2);
        self::assertSame(63, $result3);
        self::assertSame(1364, $result4);
    }

    /**
     * @test
     */
    public function sums_string_with_custom_delimiter()
    {
        $calc = $this->createCalculator();

        $result = $calc->add("//;\n2;4;6,8\n10\n12");

        self::assertSame(42, $result);
    }

    /**
     * @test
     */
    public function throws_exception_if_negative_number_present()
    {
        $calc = $this->createCalculator();

        try {
            $calc->add("1\n2,-3");
        } catch (\InvalidArgumentException $e) {
            self::assertSame('Negative numbers not allowed: [-3]', $e->getMessage());

            return;
        }

        self::fail('Negative numbers are not allowed!');
    }

    /**
     * @test
     */
    public function throws_exception_if_multiple_negative_numbers_present()
    {
        $calc = $this->createCalculator();

        try {
            $calc->add("1,-2,-3,-4");
        } catch (\InvalidArgumentException $e) {
            self::assertSame('Negative numbers not allowed: [-2, -3, -4]', $e->getMessage());

            return;
        }

        self::fail('Negative numbers are not allowed!');
    }

    /**
     * @return StringCalculator
     */
    private function createCalculator(): StringCalculator
    {
        return new StringCalculator;
    }
}
