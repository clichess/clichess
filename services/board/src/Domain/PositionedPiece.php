<?php

namespace CliChess\Board\Domain;

final class PositionedPiece
{
    public function __construct(
        private readonly Square $currentPosition,
        private readonly Pawn $piece,
    ) {
    }

    public function movedTo(Square $targetPosition): self
    {
        if (!$this->piece->can($this->currentPosition, $targetPosition)) {
            throw new IllegalMove();
        }

        return new self($targetPosition, $this->piece);
    }
}