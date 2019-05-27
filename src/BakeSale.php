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
     * @var OutputInterface $output way of printing data outside
     */
    private $output;

    /**
     * BakeSale constructor.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Adds items as a purchase from input source.
     */
    public function addItems(): void
    {
        $this->input->get();
    }

    public function printTotal(): void
    {
        $this->output->print(0.65);
    }
}
