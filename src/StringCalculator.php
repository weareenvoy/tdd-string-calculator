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
     * @param string $numbers
     *
     * @return int
     */
    public function add(string $numbers): int
    {
        return array_sum(
            explode(
                $this->defaultDelimiter,
                str_replace(
                    $this->getDelimiters($numbers),
                    $this->defaultDelimiter,
                    $this->removeDelimiterDeclaration($numbers)
                )
            )
        );
    }

    private function hasExtraDelimiter(string $numbers): bool
    {
        return 0 === strpos($numbers, '//');
    }

    private function getDelimiters(string $numbers): array
    {
        $delimitersToChange = ["\n"];
        if ($this->hasExtraDelimiter($numbers)) {
            $delimitersToChange[] = substr($numbers, 2, 1);
        }

        return $delimitersToChange;
    }

    private function removeDelimiterDeclaration(string $numbers): string
    {
        if ( ! $this->hasExtraDelimiter($numbers)) {
            return $numbers;
        }

        $pieces = explode("\n", $numbers);
        array_shift($pieces);

        return implode("\n", $pieces);
    }
}
