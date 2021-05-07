<?php

declare(strict_types=1);

namespace Rbarden\Graph\Support;

use Rbarden\Graph\Base\Graph;

final class Invariant
{
    public static function order(Graph $graph): int
    {
        $count = count(array_keys($graph->getAdjacencyList()));

        return $count;
    }

    public static function size(Graph $graph): int
    {
        $count = array_sum(array_map(static fn ($values) => count($values), $graph->getAdjacencyList()));

        if (! $graph->isDirected) {
            $count /= 2;
        }

        return $count;
    }

    public static function getOutDegrees(Graph $graph): array
    {
        return array_map(
            static fn ($neighbors) => count($neighbors),
            $graph->getAdjacencyList()
        );
    }
}
