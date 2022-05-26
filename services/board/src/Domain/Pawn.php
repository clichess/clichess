<?php

namespace CliChess\Board\Domain;

final class Pawn
{
    public function __construct(
        public readonly Square $position,
    ) {
    }

    public function canMoveTo(Square $target): bool
    {
        $rowDiff = $target->rowDiff($this->position);
        $columnDiff = $target->columnDiff($this->position);

        return (2 === $rowDiff || 1 === $rowDiff) && 0 === $columnDiff;
    }
}

// no one likes us :(