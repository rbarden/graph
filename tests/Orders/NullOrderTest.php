<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Orders;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Orders\NullOrder;

class NullOrderTest extends TestCase
{
    public function testReturnsCorrectOrderOfVertices(): void
    {
        $graph = new Graph();
        $graph->addVertex(1, 2, 3);

        $result = (new NullOrder())->find($graph);

        self::assertSame([1, 2, 3], $result);
    }

    public function testReturnsEmptyArrayOnEmptyGraph(): void
    {
        $graph = new Graph();

        $result = (new NullOrder())->find($graph);

        self::assertSame([], $result);
    }
}
