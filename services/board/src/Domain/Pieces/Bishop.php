<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class Bishop implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        $rowDiff = $to->rowDiff($from);
        $columnDiff = $to->columnDiff($from);

        return abs($rowDiff) === abs($columnDiff);
    }
}
