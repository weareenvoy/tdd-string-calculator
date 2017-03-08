<?php

/**
 * Class StringCalculator
 */
class StringCalculator
{
    /**
     * @param string $numbers
     *
     * @return int
     */
    public function add(string $numbers): int
    {
        $delimitersToChange = ["\n"];
        if ($this->hasExtraDelimiter($numbers)) {
            $delimitersToChange[] = substr($numbers, 2, 1);
            $pieces = explode("\n", $numbers);
            array_shift($pieces);
            $numbers = implode("\n", $pieces);
        }

        return array_sum(explode(',', str_replace($delimitersToChange, ',', $numbers)));
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
}
