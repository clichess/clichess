<?php

namespace CliChess\Board\Domain;

final class Board
{
    /** @var Move[] */
    private array $moves;

    public function __construct(
        public readonly BoardId $id,
        public Pawn $piece,
        Move ...$moves,
    ) {
        $this->moves = $moves;
    }

    public function apply(Move $move): void
    {
        if (!$this->piece->canMoveTo($move->targetSquare())) {
            throw new IllegalMove();
        }

        $this->moves[] = $move;
        $this->piece = $this->piece->positionedAt($move->targetSquare());

        Events::collect(new MoveApplied($this));
    }


}
