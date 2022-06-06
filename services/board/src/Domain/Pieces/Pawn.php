<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class Pawn implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        $rowDiff = $to->rowDiff($from);
        $columnDiff = $to->columnDiff($from);

        return (2 === $rowDiff || 1 === $rowDiff) && 0 === $columnDiff;
    }
}
