<?php

namespace CliChess\Board\Domain\MovingStrategies;

use CliChess\Board\Domain\Square;

class CombinedStrategy implements Moving
{
    private readonly array $strategies;

    public function __construct(Moving ...$strategies)
    {
        $this->strategies = $strategies;
    }
    public function canMove(Square $from, Square $to): bool
    {
        foreach($this->strategies as $key => $strategy) {
            if (!$strategy->canMove($from, $to)) {
                return false;
            }
        }

        return true;
    }
}
