<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

final class Knight implements Piece
{
    public function canMove(Square $from, Square $to): bool
    {
        return true;
    }
}
