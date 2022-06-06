<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\Square;

interface Piece
{
    public function canMove(Square $from, Square $to): bool;
}
