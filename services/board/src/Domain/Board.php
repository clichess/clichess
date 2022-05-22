<?php

namespace CliChess\Board\Domain;

final class Board
{
    /** @var Move[] */
    private array $moves;

    public function __construct(
        public readonly BoardId $id,
        Move ...$moves,
    ) {
        $this->moves = $moves;
    }

    public function apply(Move $move): void
    {
        if ($move->value !== 'e4') {
            throw new IllegalMove();
        }

        $this->moves[] = $move;
        Events::collect(new MoveApplied($this));
    }
}