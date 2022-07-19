<?php

namespace CliChess\Board\Domain\Piece\MovingStrategies;

use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Position\MovingPiece;

class ConstrainedIfAlreadyMoved implements MovingStrategy
{
    public function __construct(
        private readonly MovingStrategy $constrained,
    ) {
    }

    public function allow(MovingPiece $movingPiece): bool
    {
        return $movingPiece->wasNotMovedYet() && $this->constrained->allow($movingPiece);
    }
}
