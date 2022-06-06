<?php

namespace CliChess\Board\Domain;

final class Pawn
{
    public function __construct(
        public readonly Square $position,
        private readonly bool $hasMoved = false
    ) {
    }

    public function canMoveTo(Square $target): bool
    {
        $rowDiff = $target->rowDiff($this->position);
        $columnDiff = $target->columnDiff($this->position);

        return (2 === $rowDiff && !$this->hasMoved || 1 === $rowDiff) && 0 === $columnDiff;
    }

    public function positionedAt(Square $square): self
    {
        return new self($square, true);
    }
}

// no one likes us :(