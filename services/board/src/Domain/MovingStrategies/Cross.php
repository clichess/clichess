<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class Cross implements Moving
{
    public function canMove(Square $from, Square $to): bool
    {
        return $from->onSameColumnAs($to) || $from->onSameRowAs($to);
    }
}
