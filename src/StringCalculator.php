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
        $this->guardNegativeNumbers($numbers);

        return array_sum(array_filter($numbers, function ($number) {
            return 1000 >= $number;
        }));
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
        $delimitersToChange = [];

        if ($this->hasExtraDelimiter($numbers)) {
            if ($this->hasMultiCharacterDelimiter($numbers)) {
                $matches = [];
                preg_match(';^\/\/\[([^\]]+)\];', $numbers, $matches);
                $delimitersToChange[] = $matches[1];
            } else {
                $delimitersToChange[] = substr($numbers, 2, 1);
            }
        }
        $delimitersToChange[] = "\n";

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

    /**
     * @param string $numbers
     *
     * @return bool
     */
    private function hasMultiCharacterDelimiter(string $numbers): bool
    {
        return 2 === strpos($numbers, '[');
    }

    /**
     * @param array $numbers
     *
     * @throws InvalidArgumentException
     */
    private function guardNegativeNumbers(array $numbers)
    {
        $negatives = [];

        array_walk($numbers, function ($number) use (&$negatives) {
            if (0 > (int)$number) {
                $negatives[] = $number;
            }
        });

        if (0 < count($negatives)) {
            throw new InvalidArgumentException('Negative numbers not allowed: [' . implode(', ', $negatives) . ']');
        }
    }
}
