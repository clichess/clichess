<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\LShape;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class Knight extends Piece
{
    protected function movingStrategy(): MovingStrategy
    {
        return new LShape();
    }
}
