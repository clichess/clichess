<?php

namespace CliChess\Board\Domain;

use CliChess\Board\Domain\Position\Position;

final class Board
{
    public readonly BoardId $id;
    public readonly Position $initialPosition;
    /** @var Move[] */ private array $moves = [];

    private function __construct()
    {
    }

    public function apply(Move $move): void
    {
        $this
            ->currentPosition()
            ->withMoveApplied($move);

        $this->moves[] = $move;

        MutatedAggregate::add($this);
    }

    private function currentPosition(): Position
    {
        return $this->initialPosition->withMovesApplied(...$this->moves);
    }
}
