<?php

/**
 * Basic test suite for BakeSale functionalities.
 */

namespace Test;

use App\BakeSale;
use App\InputInterface;
use App\OutputInterface;
use Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionException;

/**
 * Class BakeSaleTest
 *
 * @package Test
 */
class BakeSaleTest extends TestCase
{
    /**
     * @var MockObject|InputInterface $input way of getting input data into application
     */
    private $input;

    /**
     * @var MockObject|OutputInterface $output way of presenting output data from application
     */
    private $output;

    /**
     * @var BakeSale $bakeSale main application
     */
    private $bakeSale;

    /**
     * Sets up mocks and main application.
     *
     * @throws ReflectionException
     */
    protected function setUp(): void
    {
        $this->input = $this->getMockBuilder(InputInterface::class)
            ->setMethods(['get'])
            ->getMock();

        $this->output = $this->getMockBuilder(OutputInterface::class)
            ->setMethods(['print'])
            ->getMock();

        $this->bakeSale = new BakeSale($this->input, $this->output);
    }

    /**
     * Tests calculating total purchase price based on given input.
     *
     * @dataProvider singlePurchaseProvider
     *
     * @param string $input
     * @param string $expected
     */
    public function testSinlePurchase(string $input, string $expected): void
    {
        $this->input->expects($this->once())
            ->method('get')
            ->willReturn($input);
        $this->bakeSale->addItems();

        $this->output->expects($this->once())
            ->method('print')
            ->with($this->equalTo($expected));

        $this->bakeSale->printTotal();
    }

    /**
     * Tests multiple purchases against the same set of items (quantity).
     *
     * @dataProvider multiplePurchasesProvider
     *
     * @param array $input
     * @param string $expected
     */
    public function testMultiplePurchases(array $input, string $expected): void
    {
        $this->input
            ->method('get')
            ->willReturnOnConsecutiveCalls(...$input);

        for ($i = 0, $iMax = count($input); $i < $iMax; $i++) {
            $this->bakeSale->addItems();
        }

        $this->output->expects($this->once())
            ->method('print')
            ->with($this->equalTo($expected));
        $this->bakeSale->printTotal();
    }

    /**
     * Provides data with single purchase for calculating total price.
     * Input - single purchase string.
     * Output - expected total price.
     *
     * @return Generator
     */
    public function singlePurchaseProvider(): Generator
    {
        yield 'brownie' => [
            'input' => 'B',
            'expected' => '0.65'
        ];
        yield 'muffin' => [
            'input' => 'M',
            'expected' => '1.00'
        ];
        yield 'multiple items' => [
            'input' => 'B,C,W',
            'expected' => '3.50'
        ];
    }

    /**
     * Provides data with multiple purchases for checking quantity.
     * Input - list of purchases.
     * Output -  expected total price after last purchase.
     *
     * @return Generator
     */
    public function multiplePurchasesProvider(): Generator
    {
        yield 'simple two purchases' => [
            'input' => [
                'B',
                'B,C,W'
            ],
            'expected' => '3.50'
        ];
    }
}
