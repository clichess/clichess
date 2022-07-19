<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\Any;
use CliChess\Board\Domain\Piece\MovingStrategies\StraightLine;
use CliChess\Board\Domain\Piece\MovingStrategies\Diagonal;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class Queen extends Piece
{
    protected function movingStrategy(): MovingStrategy
    {
        return new Any(new StraightLine(), new Diagonal());
    }
}
