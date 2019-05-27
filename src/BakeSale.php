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
     * @var array available items with cost
     */
    private const ITEMS = [
        'B' => 0.65,
        'M' => 1.00,
        'C' => 1.35,
        'W' => 1.50
    ];

    /**
     * @var InputInterface $input way of getting data into application
     */
    private $input;

    /**
     * @var OutputInterface $output way of printing data outside
     */
    private $output;

    /**
     * @var float $totalPrice total cost form items from single purchase
     */
    private $totalPrice;

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

        $this->totalPrice = 0.00;
    }

    /**
     * Adds items as a purchase from input source.
     */
    public function addItems(): void
    {
        $input = explode(',', $this->input->get());
        foreach ($input as $item) {
            $this->totalPrice += self::ITEMS[$item];
        }
    }

    /**
     * Prints total price to specified output.
     */
    public function printTotal(): void
    {
        $this->output->print($this->getFormattedPrice());
    }

    /**
     * Returns formatted total price as string.
     *
     * @return string formatted total price
     */
    private function getFormattedPrice(): string
    {
        return number_format($this->totalPrice, 2, '.', '');
    }
}
