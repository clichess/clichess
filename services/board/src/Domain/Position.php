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
        $pawn = $this->pieces[0];

        $movedPawn = $pawn->movedTo($move->targetSquare());

        return new self($movedPawn);
    }
}