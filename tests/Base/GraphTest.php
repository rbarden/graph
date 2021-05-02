<?php

declare(strict_types=1);

namespace  Rbarden\Graph\Tests\Base;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\DuplicateVertexException;
use Rbarden\Graph\Exceptions\UnknownVertexException;

class GraphTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph();
    }

    public function testIsInitiallyDirectedAndEmpty(): void
    {
        self::assertEquals(true, $this->graph->isDirected);
        self::assertEmpty($this->graph->getAdjacencyList());
    }

    public function testCanBeConstructedWithDirectednessAndAdjacencyList()
    {
        $graph = new Graph(false);

        self::assertFalse($graph->isDirected);
    }

    public function testCanHaveVertices(): void
    {
        $this->graph->addVertex();
        $this->graph->addVertex(1);
        $this->graph->addVertex(2, 3);

        self::assertEquals(
            [
                1 => [],
                2 => [],
                3 => [],
            ],
            $this->graph->getAdjacencyList()
        );
    }

    public function testCannotHaveDuplicateVertices(): void
    {
        $this->expectException(DuplicateVertexException::class);

        $this->graph->addVertex(1, 1);
    }

    public function testCanSetAdjacencyMatrix(): void
    {
        $list = [
            1 => [2],
            2 => [3],
            3 => [1],
        ];

        $this->graph->setAdjacencyList($list);
        self::assertEquals(
            $list,
            $this->graph->getAdjacencyList()
        );
    }

    public function testCanGetNeighborsOfVertexWithNeighbors(): void
    {
        $neighbors = $this->graph->addVertex(1, 2)
            ->addEdgeFrom(1, 2)
            ->getNeighborsOf(1);

        self::assertEquals([2], $neighbors);
    }

    public function testCanGetNeighborsOfVertexWithoutNeighbors(): void
    {
        $neighbors = $this->graph->addVertex(1)
            ->getNeighborsOf(1);

        self::assertEquals([], $neighbors);
    }

    public function testCannotGetNeighborsOfUnknownVertex(): void
    {
        $this->expectException(UnknownVertexException::class);
        $this->graph->getNeighborsOf(1);
    }
}
