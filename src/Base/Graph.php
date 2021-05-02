<?php

declare(strict_types=1);

namespace Rbarden\Graph\Base;

use Rbarden\Graph\Exceptions\DuplicateVertexException;
use Rbarden\Graph\Exceptions\UnknownVertexException;

class Graph
{
    public bool $isDirected = true;

    protected array $adjacencyList = [];

    public function __construct(bool $isDirected = true)
    {
        $this->isDirected = $isDirected;
    }

    public function getAdjacencyList(): array
    {
        return $this->adjacencyList;
    }

    public function setAdjacencyList(array $adjacencyList): self
    {
        $this->adjacencyList = $adjacencyList;

        return $this;
    }

    public function addVertex(int ...$vertices): self
    {
        foreach ($vertices as $vertex) {
            if (isset($this->adjacencyList[$vertex])) {
                throw new DuplicateVertexException("Cannot add duplicate vertex [$vertex] to graph");
            }
            $this->adjacencyList[$vertex] = [];
        }

        return $this;
    }

    public function addEdgeFrom(int $source, int ...$destinations): self
    {
        if (! isset($this->adjacencyList[$source])) {
            throw new UnknownVertexException("Cannot add edge containing unknown source vertex [$source] to graph");
        }
        foreach ($destinations as $destination) {
            if (! isset($this->adjacencyList[$destination])) {
                throw new UnknownVertexException("Cannot add edge containing unknown destination vertex [$destination] to graph");
            }
            $this->adjacencyList[$source][] = $destination;
            if (! $this->isDirected) {
                $this->adjacencyList[$destination][] = $source;
            }
        }

        return $this;
    }

    public function getNeighborsOf(int $vertex): array
    {
        if (! isset($this->adjacencyList[$vertex])) {
            throw new UnknownVertexException("Cannot get neighbors of unknown vertex [$vertex] in graph");
        }

        return $this->adjacencyList[$vertex];
    }
}
