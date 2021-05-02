<?php

declare(strict_types=1);

namespace Rbarden\Graph\Orders;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;
use Rbarden\Graph\Exceptions\UnknownVertexException;

final class GivenOrder implements Order
{
    public function __construct(
        private array $order
    ) {
    }

    public function find(Graph $graph): array
    {
        foreach ($this->order as $vertex) {
            if (! isset($graph->getAdjacencyList()[$vertex])) {
                throw new UnknownVertexException("Cannot use unknown vertex [$vertex] in given order");
            }
        }

        return $this->order;
    }
}
