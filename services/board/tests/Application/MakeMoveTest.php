<?php
//
//namespace CliChess\Board;
//
//use CliChess\Board\Application\InMemoryBoardRepository;
//use InvalidArgumentException;
//use CliChess\Board\Application\Move\BoardNotFound;
//use CliChess\Board\Application\Move\MakeMove;
//use CliChess\Board\Application\Move\MakeMoveHandler;
//use PHPUnit\Framework\TestCase;
//
//class MakeMoveTest extends TestCase
//{
//    private MakeMoveHandler $handler;
//
//    public function setUp(): void
//    {
//        $repo = new InMemoryBoardRepository(
//            Stubber::boardWith('board-id'),
//        );
//
//        $this->handler = new MakeMoveHandler($repo);
//    }
//
//    /**
//     * @test
//     */
//    public function throwExceptionIfMoveHasInvalidFormat(): void
//    {
//        $command = new MakeMove('board-id', 'invalid');
//
//        self::expectException(InvalidArgumentException::class);
//
//        ($this->handler)($command);
//    }
//
//    /**
//     * @test
//     */
//    public function throwExceptionIfNoBoardIsFound(): void
//    {
//        $command = new MakeMove('not-existing-board-id', 'e4');
//
//        self::expectException(BoardNotFound::class);
//
//        ($this->handler)($command);
//    }
//}