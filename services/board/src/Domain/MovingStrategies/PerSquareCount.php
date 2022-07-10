<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class PerSquareCount implements Moving
{
    public function __construct(
        private readonly int $count
    ) {
    }

    public function canMove(Square $from, Square $to): bool
    {
        return $this->count === abs($from->rowDiff($to)) || $this->count === abs($from->columnDiff($to));
    }
}
