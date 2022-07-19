<?php

namespace CliChess\Board\Domain\Piece;

use CliChess\Board\Domain\Position\MovingPiece;

interface MovingStrategy
{
    public function allow(MovingPiece $movingPiece): bool;
}
