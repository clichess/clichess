<?php

namespace CliChess\Board\Domain;

final class PieceArrangement
{
    private readonly array $pawns;

    public function __construct(Pawn ...$pawns)
    {
        $this->pawns = $pawns;
    }

    public function withPieceMoved(Move $move): self
    {
        $clone = clone $this;
        $clone->findPieceThatCanMoveTo($move->targetSquare())

        return $clone;
    }

    private function findPieceThatCanMoveTo(Square $to): Pawn
    {
        $pieces = array_filter($this->pawns, fn (Pawn $p): bool => $p->canMoveTo($to));

        return $pieces[0]; // TODO ensure if has one piece
    }

    private function findPieceThatCanMoveTo(Square $to): Pawn
    {
        $pieces = array_filter($this->pawns, fn (Pawn $p): bool => $p->canMoveTo($to));

        return $pieces[0]; // TODO ensure if has one piece
    }
}