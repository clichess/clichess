<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\MovingStrategies\Cross;
use CliChess\Board\Domain\MovingStrategies\Moving;
use CliChess\Board\Domain\Square;

final class Rook implements Piece
{
    private Moving $strategy;

    public function __construct()
    {
        $this->strategy = new Cross();
    }

    public function canMove(Square $from, Square $to): bool
    {
        return $this->strategy->canMove($from, $to);
    }
}
