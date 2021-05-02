<?php

declare(strict_types=1);

namespace Rbarden\Graph\Base;

interface Visitor
{
    public function visit(int $vertex): mixed;
}
