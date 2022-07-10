<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

interface Moving
{
    public function canMove(Square $from, Square $to): bool;
}
