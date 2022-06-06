<?php

namespace CliChess\Board\Domain;

final class Board
{
    /** @var Move[] */
    private array $moves;

    public function __construct(
        public readonly BoardId $id,
        public readonly Position $initialPosition,
        Move ...$moves,
    ) {
        $this->moves = $moves;
    }

    public function apply(Move $move): void
    {
        $position = $this->replayMoves();
        $position->withMoveApplied($move);

        $this->moves[] = $move;

        MutatedAggregate::add($this);
    }

    private function replayMoves(): Position
    {
        $position = $this->initialPosition;

        foreach ($this->moves as $move) {
            $position = $position->withMoveApplied($move);
        }

        return $position;
    }
}
