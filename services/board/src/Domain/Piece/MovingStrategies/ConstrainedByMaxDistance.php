<?php

namespace CliChess\Board\Domain\Piece\MovingStrategies;

use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Position\MovingPiece;

class ConstrainedByMaxDistance implements MovingStrategy
{
    public function __construct(
        private readonly int $maxDistance,
        private readonly MovingStrategy $constrained,
    ) {
    }

    public function allow(MovingPiece $movingPiece): bool
    {
        $distance = max($movingPiece->rowDistance(), $movingPiece->columnDistance());

        return $distance <= $this->maxDistance && $this->constrained->allow($movingPiece);
    }
}
