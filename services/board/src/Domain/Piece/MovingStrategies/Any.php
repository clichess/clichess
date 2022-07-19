<?php

namespace CliChess\Board\Domain\Piece\MovingStrategies;

use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Position\MovingPiece;

class Any implements MovingStrategy
{
    private readonly array $strategies;

    public function __construct(MovingStrategy ...$strategies)
    {
        $this->strategies = $strategies;
    }

    public function allow(MovingPiece $movingPiece): bool
    {
        $allowingStrategies = array_filter(
            $this->strategies,
            fn (MovingStrategy $m): bool => $m->allow($movingPiece),
        );

        return [] !== $allowingStrategies;
    }
}
