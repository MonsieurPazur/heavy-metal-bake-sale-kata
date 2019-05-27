<?php

/**
 * Interface for printing output to some external service.
 */

namespace App;

/**
 * Interface OutputInterface
 *
 * @package App
 */
interface OutputInterface
{
    /**
     * Prints output to some external service.
     *
     * @param string $input what we want to be printed
     */
    public function print(string $input): void;
}
