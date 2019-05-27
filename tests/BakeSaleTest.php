<?php

/**
 * Basic test suite for BakeSale functionalities.
 */

namespace Test;

use App\BakeSale;
use App\InputInterface;
use App\OutputInterface;
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
     * Tests inputing items to purchase.
     */
    public function testInput(): void
    {
        $this->input->expects($this->once())
            ->method('get')
            ->willReturn('B');
        $this->bakeSale->addItems();

        $this->output->expects($this->once())
            ->method('print')
            ->with($this->equalTo(0.65));

        $this->bakeSale->printTotal();
    }
}
