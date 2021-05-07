<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Support;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Support\Invariant;

class InvariantTest extends TestCase
{
    private Graph $graph;
    private Graph $graph2;

    protected function setUp(): void
    {
        $this->graph = new Graph();
        $this->graph->setAdjacencyList([
            1 => [2, 3],
            2 => [3],
            3 => [],
        ]);

        $this->graph2 = new Graph(false);
        $this->graph2->setAdjacencyList([
            1 => [2, 3],
            2 => [1, 3],
            3 => [1, 2],
        ]);
    }

    public function testOutDegreesAreCalculatedCorrectly(): void
    {
        self::assertEquals([1 => 2, 2 => 1, 3 => 0], Invariant::getOutDegrees($this->graph));
    }

    public function testOrderIsCalculatedCorrectly(): void
    {
        self::assertEquals(3, Invariant::order($this->graph));
        self::assertEquals(0, Invariant::order(new Graph()));

        self::assertEquals(3, Invariant::order($this->graph2));
    }

    public function testSizeIsCalculatedCorrectly(): void
    {
        self::assertEquals(3, Invariant::size($this->graph));
        self::assertEquals(0, Invariant::size(new Graph()));

        self::assertEquals(3, Invariant::size($this->graph2));
    }
}
