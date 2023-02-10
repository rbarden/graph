<?php

declare(strict_types=1);

namespace Rbarden\Graph\Tests\Support;

use PHPUnit\Framework\TestCase;
use Rbarden\Graph\Base\Graph;
use Rbarden\Graph\Support\Components;

class ComponentsTest extends TestCase
{
    private Graph $graph;

    protected function setUp(): void
    {
        $this->graph = new Graph();
        $this->graph->setAdjacencyList(
            [
                1 => [2],
                2 => [1],
                3 => [4],
                4 => [],
            ]
        );
    }

    public function testCannotBeInstantiatedDirectly(): void
    {
        $this->expectException(\Error::class);

        new Components();
    }

    public function testReturnsComponentsOfGraph(): void
    {
        $array = array_map(fn($graph) => $graph->getAdjacencyList(), Components::of($this->graph));

        $this->assertSame($array, [
            [1 => [2], 2 => [1]],
            [3 => [4], 4 => []],
        ]);
    }
}
