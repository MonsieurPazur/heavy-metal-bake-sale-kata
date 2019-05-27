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
        'B' => [
            'price' => 0.65,
            'quantity' => 48
        ],
        'M' => [
            'price' => 1.00,
            'quantity' => 36
        ],
        'C' => [
            'price' => 1.35,
            'quantity' => 24
        ],
        'W' => [
            'price' => 1.50,
            'quantity' => 30
        ]
    ];

    /**
     * @var array $quantities list of items with current quantities
     */
    private $quantities;

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
     * @var bool $outOfStock true if at least one item cannot be purchased due to lack of quantity
     */
    private $outOfStock;

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

        $this->initQuantities();
    }

    /**
     * Adds items as a purchase from input source.
     */
    public function addItems(): void
    {
        $this->totalPrice = 0.00;
        $this->outOfStock = false;
        $items = explode(',', $this->input->get());
        if ($this->checkItemsOnStock($items)) {
            foreach ($items as $item) {
                $this->totalPrice += self::ITEMS[$item]['price'];
                $this->quantities[$item]--;
            }
        } else {
            $this->outOfStock = true;
        }
    }

    /**
     * Prints total price (or error, when out of stock) to specified output.
     */
    public function printTotal(): void
    {
        if ($this->outOfStock) {
            $this->output->print('Not enough stock.');
        } else {
            $this->output->print($this->getFormattedPrice());
        }
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

    /**
     * Initializes quantities based on items list.
     */
    private function initQuantities(): void
    {
        $this->quantities = [];
        foreach (self::ITEMS as $symbol => $item) {
            $this->quantities[$symbol] = $item['quantity'];
        }
    }

    /**
     * Checks whether there are enough items to sell.
     *
     * @param array $items given items to check
     *
     * @return bool true if all given items are on stock
     */
    private function checkItemsOnStock(array $items): bool
    {
        foreach ($items as $item) {
            if (0 === $this->quantities[$item]) {
                return false;
            }
        }
        return true;
    }
}
