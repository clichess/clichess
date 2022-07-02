<?php

namespace CliChess\Board\Domain\Position;

use CliChess\Board\Domain\Pieces\Piece;
use CliChess\Board\Domain\Square;

final class PositionedPiece
{
    public function __construct(
        private readonly Square $square,
        private readonly Piece $piece,
    ) {
    }

    public function movedTo(Square $targetSquare): self
    {
        if (!$this->piece->canMove($this->square, $targetSquare)) {
            throw new IllegalMove();
        }

        return new self($targetSquare, $this->piece);
    }
}