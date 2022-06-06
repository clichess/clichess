<?php

namespace CliChess\Board\Domain;

final class Pawn
{
    public function __construct(
    ) {
    }

    public function can(Square $from, Square $to): bool
    {
        $rowDiff = $to->rowDiff($from);
        $columnDiff = $to->columnDiff($from);

        return (2 === $rowDiff || 1 === $rowDiff) && 0 === $columnDiff;
    }
}
