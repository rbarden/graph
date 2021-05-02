<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Support;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Support\Transformation;

class ConverseTransformationTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph();
    }

    public function testReturnsSameGraphIfUndirected():void
    {
        $this->graph->isDirected = false;
        $this->graph->setAdjacencyList([
            1 => [2, 3],
            2 => [1, 3],
            3 => [1, 2],
        ]);

        self::assertEquals($this->graph->getAdjacencyList(), Transformation::converse($this->graph)->getAdjacencyList());
    }

    public function testReturnsCorrectConverseOfDirectedGraph(): void
    {
        $this->graph->setAdjacencyList([
            1 => [2],
            2 => [3],
            3 => [1],
        ]);

        self::assertEquals([1 => [3], 2 => [1], 3 => [2]], Transformation::converse($this->graph)->getAdjacencyList());
    }
}
