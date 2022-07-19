<?php

namespace CliChess\Board\Domain\Piece;

use CliChess\Board\Domain\Position\MovingPiece;

abstract class Piece
{
    private function __construct()
    {
    }

    public static function fromChar(string $char): self
    {
        return match ($char) {
            'B' => new Types\Bishop(),
            'K' => new Types\King(),
            'N' => new Types\Knight(),
            'P' => new Types\Pawn(),
            'Q' => new Types\Queen(),
            'R' => new Types\Rook(),
        };
    }

    public function allow(MovingPiece $movingPiece): bool
    {
        return $this
            ->movingStrategy()
            ->allow($movingPiece);
    }

    abstract protected function movingStrategy(): MovingStrategy;
}
