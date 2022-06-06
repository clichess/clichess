<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class Knight implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        $columnDiff = abs($from->columnDiff($to));
        $rowDiff = abs($from->rowDiff($to));

        return 2 === $columnDiff * $rowDiff;
    }
}
