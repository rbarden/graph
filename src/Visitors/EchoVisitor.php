<?php

declare(strict_types=1);

namespace Rbarden\Graph\Visitors;

use Rbarden\Graph\Base\Visitor;

class EchoVisitor implements Visitor
{
    public function __construct(
        private string $prefix = '',
    ) {
    }

    public function visit(int $vertex): mixed
    {
        $string = $this->prefix . $vertex . "\n";
        echo $string;

        return $string;
    }
}
