<?php

/**
 * An application for selling items (calculating total and returning change).
 */

namespace App;

/**
 * Class BakeSale
 *
 * @package App
 */
class BakeSale
{
    /**
     * @var InputInterface $input way of getting data into application
     */
    private $input;

    /**
     * BakeSale constructor.
     *
     * @param InputInterface $input
     */
    public function __construct(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * Adds items as a purchase from input source.
     */
    public function addItems(): void
    {
        $this->input->get();
    }
}
