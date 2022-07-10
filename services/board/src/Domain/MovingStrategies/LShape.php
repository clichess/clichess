<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class LShape implements Moving
{
    public function canMove(Square $from, Square $to): bool
    {
        $columnDiff = abs($from->columnDiff($to));
        $rowDiff = abs($from->rowDiff($to));

        return 2 === $columnDiff * $rowDiff;
    }
}
