<?php

namespace CliChess\Board\Domain\Position;

use CliChess\Board\Domain\Move;
use CliChess\Board\Domain\Piece\Piece;
use CliChess\Board\Domain\Square;

final class Position
{
    private array $pieces;

    public function __construct(PositionedPiece ...$pieces)
    {
        $this->pieces = $pieces;
    }

    public static function fromArray(array $arr): self
    {
        $pieces = [];

        foreach ($arr as $square => $piece) {
            $pieces[] = PositionedPiece::new(Piece::fromChar($piece), Square::fromString($square));
        }

        return new self(...$pieces);
    }

    public function withMoveApplied(Move $move): self
    {
        $piece = $this->pieces[0];
        $movedPiece = $piece->movedTo($move->targetSquare());

        return new self($movedPiece);
    }

    public function withMovesApplied(Move ...$moves): self
    {
        return [] === $moves ? $this : $this
            ->withMoveApplied($moves[0])
            ->withMovesApplied(...array_slice($moves, 1));
    }
}