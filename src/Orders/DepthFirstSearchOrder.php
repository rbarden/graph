<?php

declare(strict_types=1);

namespace Rbarden\Graph\Orders;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;
use Rbarden\Graph\Exceptions\UnknownVertexException;
use SplStack;

final class DepthFirstSearchOrder implements Order
{
    public function __construct(
        private int $root = 0,
    ) {
    }

    public function find(Graph $graph): array
    {
        $adjacencyList = $graph->getAdjacencyList();

        if (! isset($adjacencyList[$this->root])) {
            throw new UnknownVertexException("Cannot use unknown vertex [$this->root] in BFS order");
        }

        $discovered = array_fill_keys(array_keys($adjacencyList), false);
        $stack = new SplStack();
        $sortedList = [];

        $stack->push($this->root);

        while (! $stack->isEmpty()) {
            $current = $stack->pop();
            $sortedList[] = $current;

            if (! $discovered[$current]) {
                $discovered[$current] = true;
                foreach ($adjacencyList[$current] as $destination) {
                    $stack->push($destination);
                }
            }
        }

        return $sortedList;
    }
}
