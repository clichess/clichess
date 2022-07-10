<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class Forward implements Moving
{
    public function canMove(Square $from, Square $to): bool
    {
        return $from->onSameColumnAs($to);
    }
}
