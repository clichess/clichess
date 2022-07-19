<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\MovingStrategies\AnyStrategy;
use CliChess\Board\Domain\Square;
use CliChess\Board\Domain\MovingStrategies\CombinedStrategy;
use CliChess\Board\Domain\MovingStrategies\Cross;
use CliChess\Board\Domain\MovingStrategies\Diagonal;
use CliChess\Board\Domain\MovingStrategies\Moving;
use CliChess\Board\Domain\MovingStrategies\PerSquareCount;

final class King implements Piece
{
    private Moving $strategy;
    
    public function __construct()
    {
        $this->strategy = new CombinedStrategy(
            new PerSquareCount(1),
            new AnyStrategy(
                new Cross(),
                new Diagonal(),
            ),
        );
    }

    public function canMove(Square $from, Square $to): bool
    {
        return $this->strategy->canMove($from, $to);
    }
}
