<?php

namespace CliChess\Board\Domain;

final class Position
{
    private array $pieces;

    public function __construct(PositionedPiece ...$pieces)
    {
        $this->pieces = $pieces;
    }

    public function withMoveApplied(Move $move): self
    {
        $piece = $this->pieces[0];

        $movedPiece = $piece->movedTo($move->targetSquare());

        return new self($movedPiece);
    }
}