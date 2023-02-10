<?php

declare(strict_types=1);

namespace Rbarden\Graph\Support;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Orders\BreadthFirstSearchOrder;

final class Components
{
    private function __construct(private Graph $graph)
    {}

    public static function of(Graph $graph): array
    {
        $vertices = array_keys($graph->getAdjacencyList());

        $components = [];
        $visitedVertices = [];

        foreach ($vertices as $vertex) {
            if ($visitedVertices[$vertex] ?? false) {
                continue;
            }

            [$seenVertices, ] = Traversal::over($graph)
                ->usingOrder(new BreadthFirstSearchOrder($vertex))
                ->traverse();

            $components[] = (new Graph($graph->isDirected))
                ->setAdjacencyList(array_intersect_key($graph->getAdjacencyList(), array_flip($seenVertices)));

            foreach($seenVertices as $seenVertex) {
                $visitedVertices[$seenVertex] = true;
            }
        }

        return $components;
    }
}
