<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Support;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Exceptions\UnknownOrderException;
use Rbarden\Graph\Orders\NullOrder;
use Rbarden\Graph\Support\Traversal;
use Rbarden\Graph\Visitors\EchoVisitor;

class TraversalTest extends TestCase
{
    private Graph $graph;
    private Traversal $traversal;

    protected function setUp(): void
    {
        $this->graph = new Graph();
        $this->graph->setAdjacencyList(
            [
                1 => [2],
                2 => [1],
            ]
        );
        $this->traversal = Traversal::over($this->graph);
    }

    public function testCannotBeInstantiatedDirectly(): void
    {
        $this->expectException(\Error::class);

        new Traversal();
    }

    public function testCanBeInstantiatedUsingOverWithGivenGraph(): void
    {
        $traversal = Traversal::over($this->graph);

        self::assertNotNull($traversal);
        self::assertSame($this->graph, $traversal->getGraph());
    }

    public function testCanSetOrder(): void
    {
        $order = new NullOrder();
        $this->traversal->usingOrder($order);

        self::assertSame($order, $this->traversal->getOrder());
    }

    public function testCanSetVisitor(): void
    {
        $visitor = new EchoVisitor();
        $this->traversal->usingVisitor($visitor);

        self::assertSame($visitor, $this->traversal->getVisitor());
    }

    public function testCanExecuteTraversal(): void
    {
        $this->expectOutputString("1\n2\n");
        $result = $this->traversal
            ->usingOrder(new NullOrder())
            ->usingVisitor(new EchoVisitor())
            ->traverse();

        self::assertSame(
            [
                [1, 2],
                [1 => "1\n", 2 => "2\n"],
            ],
            $result
        );
    }

    public function testCanExecuteTraversalWithoutVisitor(): void
    {
        $result = $this->traversal
            ->usingOrder(new NullOrder())
            ->traverse();

        self::assertSame(
            [
                [1, 2],
                [],
            ],
            $result
        );
    }

    public function testCannotExecuteTraversalWithoutOrder(): void
    {
        $this->expectException(UnknownOrderException::class);
        $this->traversal
            ->traverse();
    }
}
