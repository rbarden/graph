<?php

declare(strict_types=1);

namespace Rbarden\Graph\Support;

use Rbarden\Graph\Base\Graph;

final class Invariant
{
    public static function getOutDegrees(Graph $graph): array
    {
        return array_map(
            static fn ($neighbors) => count($neighbors),
            $graph->getAdjacencyList()
        );
    }
}
