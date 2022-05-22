<?php

namespace CliChess\Board\Domain;

interface BoardRepository
{
    public function findById(BoardId $id): ?Board;
}
