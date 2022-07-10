<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\MovingStrategies\AnyStrategy;
use CliChess\Board\Domain\MovingStrategies\CombinedStrategy;
use CliChess\Board\Domain\MovingStrategies\Forward;
use CliChess\Board\Domain\MovingStrategies\Moving;
use CliChess\Board\Domain\MovingStrategies\PerSquareCount;
use CliChess\Board\Domain\Square;

final class Pawn implements Piece
{
    private Moving $strategy;

    public function __construct()
    {
        $this->strategy = new CombinedStrategy(
            new Forward(),
            new AnyStrategy(
                new PerSquareCount(1),
                new PerSquareCount(2),
            ),
        );
    }

    public function canMove(Square $from, Square $to): bool
    {
        return $this->strategy->canMove($from, $to);
    }
}
