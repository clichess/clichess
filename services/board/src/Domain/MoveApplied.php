<?php

namespace CliChess\Board\Domain;

final class MoveApplied
{
    public function __construct(
        // @todo create event from entity values
        public readonly Board $board,
    ) {
    }
}
