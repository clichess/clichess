<?php

namespace CliChess\Board\Domain\Position;

use CliChess\Board\Domain\Square;

final class MovingPiece
{
    public function __construct(
        private readonly PositionedPiece $piece,
        private readonly Square $target,
    ) {
    }

    public function wasNotMovedYet(): bool
    {
        return !$this->piece->alreadyMoved();
    }

    public function rowDistance(): int
    {
        return abs(ord($this->piece->row()) - ord($this->target->row()));
    }

    public function columnDistance(): int
    {
        return abs(ord($this->piece->column()) - ord($this->target->column()));
    }

    public function onSameRow(): int
    {
        return 0 === $this->rowDistance();
    }

    public function onSameColumn(): bool
    {
        return 0 === $this->columnDistance();
    }

    public function onSameDiagonal(): bool
    {
        return $this->rowDistance() === $this->columnDistance();
    }
}
