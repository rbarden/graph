<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Orders;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\InvalidOrderResultException;
use Rbarden\Graph\Orders\TopologicalSortOrder;

class TopologicalSortOrderTest extends TestCase
{
    public function testReturnsCorrectOrderOfVertices(): void
    {
        $graph = new Graph();
        $graph->addVertex(5, 11, 7, 8, 3, 10, 2, 9)
            ->addEdgeFrom(5, 11)
            ->addEdgeFrom(7, 11, 8)
            ->addEdgeFrom(3, 8, 10)
            ->addEdgeFrom(11, 2, 9, 10)
            ->addEdgeFrom(8, 9);

        $result = (new TopologicalSortOrder())->find($graph);

        self::assertSame([5, 7, 3, 11, 8, 2, 10, 9], $result);
    }

    public function testReturnsEmptyArrayOnEmptyGraph(): void
    {
        $result = (new TopologicalSortOrder())->find(new Graph());

        self::assertSame([], $result);
    }

    public function testThrowsExceptionOnGraphWithCycle(): void
    {
        $this->expectException(InvalidOrderResultException::class);

        $graph = new Graph();
        $graph->addVertex(1, 2)
            ->addEdgeFrom(1, 2)
            ->addEdgeFrom(2, 1);

        (new TopologicalSortOrder())->find($graph);
    }
}
