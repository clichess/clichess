<?php

namespace CliChess\Board\Domain;

use CliChess\Board\Domain\Pieces\Piece;

final class PositionedPiece
{
    public function __construct(
        private readonly Square $currentPosition,
        private readonly Piece $piece,
    ) {
    }

    public function movedTo(Square $targetPosition): self
    {
        if (!$this->piece->canMove($this->currentPosition, $targetPosition)) {
            throw new IllegalMove();
        }

        return new self($targetPosition, $this->piece);
    }
}