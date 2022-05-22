<?php

namespace CliChess\Board;

use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Domain\Board;
use CliChess\Board\Domain\BoardId;
use CliChess\Board\Domain\Events;
use CliChess\Board\Domain\IllegalMove;
use CliChess\Board\Domain\Move;
use CliChess\Board\Domain\MoveApplied;
use InvalidArgumentException;
use CliChess\Board\Application\Move\BoardNotFound;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use PHPUnit\Framework\TestCase;

class MakeMoveTest extends TestCase
{
    private MakeMoveHandler $handler;

    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            new Board(new BoardId('board-id')),
        );

        $this->handler = new MakeMoveHandler($repo);
    }

    /**
     * @test
     */
    public function moveAppliedIsCollectedIfMoveCanBeMade(): void
    {
        $command = new MakeMove('board-id', 'e4');

        ($this->handler)($command);

        $expected = [new MoveApplied(new Board(new BoardId('board-id'), new Move('e4')))];
        $actual = Events::popAll();
        self::assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function throwExceptionIfMoveIsIllegal(): void
    {
        $command = new MakeMove('board-id', 'e5');

        self::expectException(IllegalMove::class);

        ($this->handler)($command);
    }

    /**
     * @test
     */
    public function throwExceptionIfMoveHasInvalidFormat(): void
    {
        $command = new MakeMove('board-id', 'invalid');

        self::expectException(InvalidArgumentException::class);

        ($this->handler)($command);
    }

    /**
     * @test
     */
    public function throwExceptionIfNoBoardIsFound(): void
    {
        $command = new MakeMove('not-existing-board-id', 'e4');

        self::expectException(BoardNotFound::class);

        ($this->handler)($command);
    }
}