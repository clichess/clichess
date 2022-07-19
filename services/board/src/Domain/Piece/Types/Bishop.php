<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\Diagonal;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class Bishop extends Piece
{
    protected function movingStrategy(): MovingStrategy
    {
        return new Diagonal();
    }
}
