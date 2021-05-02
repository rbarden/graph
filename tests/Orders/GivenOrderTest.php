<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Orders;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\UnknownVertexException;
use Rbarden\Graph\Orders\GivenOrder;

class GivenOrderTest extends TestCase
{
    public function testReturnsCorrectOrderOfVertices(): void
    {
        $graph = new Graph();
        $graph->addVertex(1, 2, 3);

        $result = (new GivenOrder([3, 2, 1]))->find($graph);

        self::assertSame([3, 2, 1], $result);
    }

    public function testReturnsEmptyArrayOnEmptyGraph(): void
    {
        $graph = new Graph();

        $result = (new GivenOrder([]))->find($graph);

        self::assertSame([], $result);
    }

    public function testThrowsExceptionIfGraphIsMissingGivenVertices(): void
    {
        $this->expectException(UnknownVertexException::class);

        $graph = new Graph();

        (new GivenOrder([1, 2, 3]))->find($graph);
    }
}
