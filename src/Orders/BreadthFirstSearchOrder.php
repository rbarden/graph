<?php

declare(strict_types=1);

namespace Rbarden\Graph\Orders;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;
use Rbarden\Graph\Exceptions\UnknownVertexException;
use SplQueue;

final class BreadthFirstSearchOrder implements Order
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
        $queue = new SplQueue();
        $sortedList = [];

        $discovered[$this->root] = true;
        $queue->enqueue($this->root);

        while (! $queue->isEmpty()) {
            $current = $queue->dequeue();
            $sortedList[] = $current;

            foreach ($adjacencyList[$current] as $destination) {
                if (! $discovered[$destination]) {
                    $discovered[$destination] = true;
                    $queue->enqueue($destination);
                }
            }
        }

        return $sortedList;
    }
}
