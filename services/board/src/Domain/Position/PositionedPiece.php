<?php

namespace CliChess\Board\Domain\Position;

use CliChess\Board\Domain\Piece\Piece;
use CliChess\Board\Domain\Square;

final class PositionedPiece
{
    private function __construct(
        private readonly Piece $piece,
        private readonly Square $currentSquare,
        private readonly ?Square $previousSquare,
    ) {
    }

    public static function new(Piece $piece, Square $square): self
    {
        return new self($piece, $square, null);
    }

    public function alreadyMoved(): bool
    {
        return null !== $this->previousSquare;
    }

    public function row(): string
    {
        return $this->currentSquare->row();
    }

    public function column(): string
    {
        return $this->currentSquare->column();
    }

    public function movedTo(Square $target): self
    {
        return $this->piece->allow(new MovingPiece($this, $target))
            ? new self($this->piece, $target, $this->currentSquare)
            : throw new IllegalMove();
    }
}