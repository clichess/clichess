<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\Any;
use CliChess\Board\Domain\Piece\MovingStrategies\ConstrainedByMaxDistance;
use CliChess\Board\Domain\Piece\MovingStrategies\StraightLine;
use CliChess\Board\Domain\Piece\MovingStrategies\Diagonal;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class King extends Piece
{
    private const MAX_DISTANCE = 1;

    protected function movingStrategy(): MovingStrategy
    {
        return new ConstrainedByMaxDistance(
            self::MAX_DISTANCE,
            new Any(new StraightLine(), new Diagonal()),
        );
    }
}
