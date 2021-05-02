<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Orders;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\UnknownVertexException;
use Rbarden\Graph\Orders\BreadthFirstSearchOrder;

class BreadthFirstSearchOrderTest extends TestCase
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

        $result = (new BreadthFirstSearchOrder(5))->find($graph);

        self::assertSame([5, 11, 2, 9, 10], $result);
    }

    public function testThrowsExceptionIfGraphDoesNotContainGivenRoot(): void
    {
        $this->expectException(UnknownVertexException::class);

        (new BreadthFirstSearchOrder())->find(new Graph());
    }
}
