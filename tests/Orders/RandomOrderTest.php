<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Orders;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Orders\RandomOrder;

class RandomOrderTest extends TestCase
{
    public function testReturnsCorrectOrderOfVertices(): void
    {
        $graph = new Graph();
        $graph->addVertex(1, 2, 3);

        $result = (new RandomOrder())->find($graph);

        self::assertContains(1, $result);
        self::assertContains(2, $result);
        self::assertContains(3, $result);
    }

    public function testReturnsEmptyArrayOnEmptyGraph(): void
    {
        $graph = new Graph();

        $result = (new RandomOrder())->find($graph);

        self::assertSame([], $result);
    }
}
