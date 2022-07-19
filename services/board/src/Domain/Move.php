<?php

namespace CliChess\Board\Domain;

use InvalidArgumentException;

final class Move
{
    public readonly Square $targetSquare;

    public function __construct(string $value)
    {
        $this->targetSquare = Square::fromString($value);
    }
}
