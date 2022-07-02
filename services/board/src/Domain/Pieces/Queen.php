<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class Queen implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        $rowDiff = $to->rowDiff($from);
        $columnDiff = $to->columnDiff($from);
        $canMoveDiagonally = abs($rowDiff) === abs($columnDiff);
        $canMoveStraightLine = 0 === $rowDiff || 0 === $columnDiff;

        return $canMoveDiagonally || $canMoveStraightLine;
    }
}
