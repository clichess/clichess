<?php

namespace CliChess\Board\Domain\Piece\MovingStrategies;

use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Position\MovingPiece;

class Diagonal implements MovingStrategy
{
    public function allow(MovingPiece $movingPiece): bool
    {
        return $movingPiece->onSameDiagonal();
    }
}
