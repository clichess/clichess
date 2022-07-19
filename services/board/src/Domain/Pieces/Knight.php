<?php

namespace CliChess\Board\Domain\Pieces;

use CliChess\Board\Domain\MovingStrategies\LShape;
use CliChess\Board\Domain\MovingStrategies\Moving;
use CliChess\Board\Domain\Square;

final class Knight implements Piece
{
    private Moving $strategy;

    public function __construct()
    {
        $this->strategy = new LShape();
    }

    public function canMove(Square $from, Square $to): bool
    {
        return $this->strategy->canMove($from, $to);
    }
}
