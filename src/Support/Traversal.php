<?php

declare(strict_types=1);

namespace Rbarden\Graph\Support;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;
use Rbarden\Graph\Base\Visitor;
use Rbarden\Graph\Exceptions\UnknownOrderException;

class Traversal
{
    private Graph $graph;
    private Order $order;
    private Visitor $visitor;

    private function __construct()
    {
    }

    public static function over(Graph $graph): self
    {
        $traversal = new self();
        $traversal->graph = $graph;

        return $traversal;
    }

    public function usingOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function usingVisitor(Visitor $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function traverse(): array
    {
        if (! isset($this->order)) {
            throw new UnknownOrderException('Cannot traverse graph without using an order.');
        }

        $vertices = $this->order->find($this->graph);
        $returnValues = [];

        if (isset($this->visitor)) {
            foreach ($vertices as $vertex) {
                $returnValues[$vertex] = $this->visitor->visit($vertex);
            }
        }

        return [$vertices, $returnValues];
    }

    public function getGraph(): Graph
    {
        return $this->graph;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getVisitor(): Visitor
    {
        return $this->visitor;
    }
}
