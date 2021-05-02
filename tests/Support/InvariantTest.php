<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Support;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Support\Invariant;

class InvariantTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph();
        $this->graph->setAdjacencyList([
            1 => [2, 3],
            2 => [3],
            3 => [],
        ]);
    }

    public function testOutDegreesAreCalculatedCorrectly(): void
    {
        self::assertEquals([1 => 2, 2 => 1, 3 => 0], Invariant::getOutDegrees($this->graph));
    }
}
