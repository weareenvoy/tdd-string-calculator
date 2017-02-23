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
        return array_sum(explode(',', str_replace("\n", ',', $numbers)));
    }
}
