<?php

namespace CliChess\Board\Application\Move;

use CliChess\Board\Application\BoardRepository;
use CliChess\Board\Domain\BoardId;
use CliChess\Board\Domain\Move;

final class MakeMoveHandler
{
    public function __construct(
        private readonly BoardRepository $boardRepo,
    ) {
    }

    public function __invoke(MakeMove $makeMove): void
    {
        $boardId = new BoardId($makeMove->boardId);
        $move = new Move($makeMove->move);

        $board = $this->boardRepo->findById($boardId) ?? throw new BoardNotFound();

        $board->apply($move);
    }
}
