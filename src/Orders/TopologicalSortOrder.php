<?php

declare(strict_types=1);

namespace Rbarden\Graph\Orders;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;
use Rbarden\Graph\Exceptions\InvalidOrderResultException;
use Rbarden\Graph\Support\Invariant;
use Rbarden\Graph\Support\Transformation;
use SplQueue;

/**
 * Implements Kahn's Algorithm for returning a topological sort of a given graph.
 */
final class TopologicalSortOrder implements Order
{
    public function find(Graph $graph): array
    {
        $sortedList = [];
        $queue = new SplQueue();

        $converseGraph = Transformation::converse($graph);

        $outDegrees = Invariant::getOutDegrees($converseGraph);

        // Initial setup of 0-in-degree vertex queue
        foreach ($outDegrees as $vertex => $degree) {
            if ($degree === 0) {
                $queue->enqueue($vertex);
            }
        }

        while (! $queue->isEmpty()) {
            $current = $queue->dequeue();

            $sortedList[] = $current;

            foreach ($graph->getNeighborsOf($current) as $destination) {
                if (--$outDegrees[$destination] === 0) {
                    $queue->enqueue($destination);
                }
            }
        }

        if (
            array_reduce($outDegrees, function ($carry, $item) {
                return $carry + $item;
            }, 0)
            !==
            0
        ) {
            throw new InvalidOrderResultException('There is no topological ordering due to cycles');
        }

        return $sortedList;
    }
}
