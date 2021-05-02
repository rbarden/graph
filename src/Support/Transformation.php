<?php

declare(strict_types=1);

namespace Rbarden\Graph\Support;

use Rbarden\Graph\Base\Graph;

final class Transformation
{
    public static function converse(Graph $graph): Graph
    {
        $newGraph = new Graph($graph->isDirected);

        if (! $graph->isDirected) {
            return $newGraph->setAdjacencyList($graph->getAdjacencyList());
        }

        $oldAdjacencyList = $graph->getAdjacencyList();
        $newAdjacencyList = array_fill_keys(array_keys($oldAdjacencyList), []);

        foreach ($oldAdjacencyList as $vertex => $neighbors) {
            foreach ($neighbors as $neighbor) {
                $newAdjacencyList[$neighbor][] = $vertex;
            }
        }

        return $newGraph->setAdjacencyList($newAdjacencyList);
    }
}
