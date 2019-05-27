<?php

/**
 * Interface for receiving input from some external source.
 */

namespace App;

/**
 * Interface InputInterface
 *
 * @package App
 */
interface InputInterface
{
    /**
     * Gets comma separated purchase symbols from some source.
     *
     * @return string comma separated purchases
     */
    public function get(): string;
}
