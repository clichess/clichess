<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class King implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        $columnDiff = abs($from->columnDiff($to));
        $rowDiff = abs($from->rowDiff($to));

        return ($columnDiff + $rowDiff) === 1 || ($columnDiff * $rowDiff) === 1;
    }
}
