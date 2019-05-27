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
     * @dataProvider itemsProvider
     *
     * @param string $input
     * @param string $expected
     */
    public function testCalculatingTotalPrice(string $input, string $expected): void
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
     * Provides data for further calculating.
     *
     * @return Generator
     */
    public function itemsProvider(): Generator
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
}
