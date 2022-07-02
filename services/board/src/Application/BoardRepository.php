<?php

namespace CliChess\Board\Application;

use CliChess\Board\Domain\Board;
use CliChess\Board\Domain\BoardId;

interface BoardRepository
{
    public function findById(BoardId $id): ?Board;
}
