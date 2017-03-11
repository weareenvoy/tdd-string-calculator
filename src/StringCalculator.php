<?php

/**
 * Class StringCalculator
 */
class StringCalculator
{
    /**
     * @var string
     */
    protected $defaultDelimiter = ',';

    /**
     * @param string $numbersString
     *
     * @return int
     */
    public function add(string $numbersString): int
    {
        $numbers = $this->extractNumbersToArray($numbersString);
        $negatives = [];

        array_walk($numbers, function ($number) use (&$negatives) {
            if (0 > (int)$number) {
                $negatives[] = $number;
            }
        });

        if (0 < count($negatives)) {
            throw new \InvalidArgumentException('Negative numbers not allowed: [' . implode(', ', $negatives) . ']');
        }

        return array_sum($numbers);
    }

    /**
     * @param string $numbers
     *
     * @return array
     */
    private function extractNumbersToArray(string $numbers): array
    {
        return explode(
            $this->defaultDelimiter,
            str_replace(
                $this->getDelimiters($numbers),
                $this->defaultDelimiter,
                $this->removeDelimiterDeclaration($numbers)
            )
        );
    }

    /**
     * @param string $numbers
     *
     * @return array
     */
    private function getDelimiters(string $numbers): array
    {
        $delimitersToChange = ["\n"];
        if ($this->hasExtraDelimiter($numbers)) {
            $delimitersToChange[] = substr($numbers, 2, 1);
        }

        return $delimitersToChange;
    }

    /**
     * @param string $numbers
     *
     * @return string
     */
    private function removeDelimiterDeclaration(string $numbers): string
    {
        if ( ! $this->hasExtraDelimiter($numbers)) {
            return $numbers;
        }

        $pieces = explode("\n", $numbers);
        array_shift($pieces);

        return implode("\n", $pieces);
    }

    /**
     * @param string $numbers
     *
     * @return bool
     */
    private function hasExtraDelimiter(string $numbers): bool
    {
        return 0 === strpos($numbers, '//');
    }
}
