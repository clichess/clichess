<?php

namespace CliChess\Board\Domain;

final class MoveApplied
{
    public function __construct(
        public readonly Board $board,
    ) {
    }
}
