<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class Diagonal implements Moving
{
    public function canMove(Square $from, Square $to): bool
    {
        return $from->inDiagonalWith($to);
    }
}
