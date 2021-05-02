<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Base;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\UnknownVertexException;

class DirectedGraphTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph();
    }

    public function testCanAddEdgeWithSingleDestination(): void
    {
        $this->graph->addVertex(1, 2);
        $this->graph->addEdgeFrom(1, 2);

        self::assertEquals(
            [
                1 => [2],
                2 => [],
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
                2 => [],
                3 => [],
            ],
            $this->graph->getAdjacencyList()
        );
    }

    public function testCannotAddEdgeWithUnknownSource(): void
    {
        $this->expectException(UnknownVertexException::class);

        $this->graph->addVertex(2);
        $this->graph->addEdgeFrom(1, 2);
    }

    public function testCannotAddEdgeWithUnknownDestination(): void
    {
        $this->expectException(UnknownVertexException::class);

        $this->graph->addVertex(1, 2);
        $this->graph->addEdgeFrom(1, 2, 3);
    }
}
