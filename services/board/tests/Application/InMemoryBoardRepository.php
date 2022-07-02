<?php

namespace CliChess\Board\Application;

use CliChess\Board\Domain\Board;
use CliChess\Board\Domain\BoardId;

class InMemoryBoardRepository implements BoardRepository
{
    /**
     * @var Board[]
     */
    private array $boards;

    public function __construct(Board ...$boards)
    {
        $this->boards = $boards;
    }

    public function findById(BoardId $id): ?Board
    {
        foreach ($this->boards as $board) {
            if ($board->id->equalTo($id)) {
                return $board;
            }
        }

        return null;
    }
}
