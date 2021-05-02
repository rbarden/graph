<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Base;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;

class UndirectedGraphTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph(false);
    }

    public function testCanAddEdgeWithSingleDestination(): void
    {
        $this->graph->addVertex(1, 2);
        $this->graph->addEdgeFrom(1, 2);

        self::assertEquals(
            [
                1 => [2],
                2 => [1],
            ],
            $this->graph->getAdjacencyList()
        );
    }

    public function testCanAddEdgeWithMultipleDestinations(): void
    {
        $this->graph->addVertex(1, 2, 3);
        $this->graph->addEdgeFrom(1, 2, 3);

        self::assertEquals(
            [
                1 => [2, 3],
                2 => [1],
                3 => [1],
            ],
            $this->graph->getAdjacencyList()
        );
    }
}
