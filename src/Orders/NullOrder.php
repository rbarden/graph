<?php

declare(strict_types=1);

namespace Rbarden\Graph\Orders;

use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Base\Order;

final class NullOrder implements Order
{
    public function find(Graph $graph): array
    {
        return array_keys($graph->getAdjacencyList());
    }
}
