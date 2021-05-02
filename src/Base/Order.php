<?php

declare(strict_types=1);

namespace Rbarden\Graph\Base;

interface Order
{
    public function find(Graph $graph): array;
}
