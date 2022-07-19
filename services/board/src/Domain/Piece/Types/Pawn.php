<?php

namespace CliChess\Board\Domain\Piece\Types;

use CliChess\Board\Domain\Piece\MovingStrategies\Any;
use CliChess\Board\Domain\Piece\MovingStrategies\ConstrainedByMaxDistance;
use CliChess\Board\Domain\Piece\MovingStrategies\Forward;
use CliChess\Board\Domain\Piece\MovingStrategies\ConstrainedIfAlreadyMoved;
use CliChess\Board\Domain\Piece\MovingStrategy;
use CliChess\Board\Domain\Piece\Piece;

final class Pawn extends Piece
{
    private const NORMAL_MAX_DISTANCE = 1;
    private const FIRST_MOVE_MAX_DISTANCE = 2;

    protected function movingStrategy(): MovingStrategy
    {
        $oneSquareForward = new ConstrainedByMaxDistance(self::NORMAL_MAX_DISTANCE, new Forward());
        $twoSquaresForward = new ConstrainedByMaxDistance(self::FIRST_MOVE_MAX_DISTANCE, new Forward());

        return new Any($oneSquareForward, new ConstrainedIfAlreadyMoved($twoSquaresForward));
    }
}
