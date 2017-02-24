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

        return array_sum(explode(',', str_replace($delimitersToChange, ',', $numbers)));
    }
}
