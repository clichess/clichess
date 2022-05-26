<?php

namespace CliChess\Board\Application\Move;

class MakeMove
{
    public function __construct(
        public readonly string $boardId,
        public readonly string $move,
    ) {
    }
}
