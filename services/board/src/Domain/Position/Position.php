<?php

namespace CliChess\Board\Domain\Position;

use CliChess\Board\Domain\Move;
use CliChess\Board\Domain\Pieces\Bishop;
use CliChess\Board\Domain\Pieces\Knight;
use CliChess\Board\Domain\Pieces\Pawn;
use CliChess\Board\Domain\Square;

final class Position
{
    private array $pieces;

    public function __construct(PositionedPiece ...$pieces)
    {
        $this->pieces = $pieces;
    }

    public static function fromRawArray(array $rawArray): self
    {
        $positionedPieces = [];
        foreach ($rawArray as $square => $piece) {
            $positionedPieces[] = new PositionedPiece(
                Square::fromString($square),
                match ($piece) {
                    'B' => new Bishop(),
                    'N' => new Knight(),
                    'P' => new Pawn(),
                },
            );
        }

        return new self(...$positionedPieces);
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