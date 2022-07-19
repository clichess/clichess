<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\StraightLine;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class Rook extends Piece
{
    protected function movingStrategy(): MovingStrategy
    {
        return new StraightLine();
    }
}
