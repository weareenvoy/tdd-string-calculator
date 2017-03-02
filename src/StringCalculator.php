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
        if (0 === strpos($numbers, '//')) {
            $delimitersToChange[] = substr($numbers, 2, 1);
            $pieces = explode("\n", $numbers);
            array_shift($pieces);
            $numbers = implode("\n", $pieces);
        }

        return array_sum(explode(',', str_replace($delimitersToChange, ',', $numbers)));
    }
}
