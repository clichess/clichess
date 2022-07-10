<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class LimitedStrategy implements Moving
{
    private int $counter;

    public function __construct(
        private readonly Moving $moving,
        private readonly int $limit
    ) {
        $this->counter = 0;
    }

    public function canMove(Square $from, Square $to): bool
    {
        if ($this->counter >= $this->limit) {
            return false;
        }

        $this->counter++;

        return $this->moving->canMove($from, $to);
    }
}
