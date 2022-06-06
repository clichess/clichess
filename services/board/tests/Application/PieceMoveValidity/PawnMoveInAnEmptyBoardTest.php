<?php

namespace CliChess\Board\PieceMoveValidity;

use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\Events;
use CliChess\Board\Domain\IllegalMove;
use CliChess\Board\Domain\MoveApplied;
use CliChess\Board\Stubber;
use PHPUnit\Framework\TestCase;

class PawnMoveInAnEmptyBoardTest extends TestCase
{
    private MakeMoveHandler $handler;

    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(Stubber::boardWith(id: 'board-id', piecePosition: 'e2'));
        $this->handler = new MakeMoveHandler($repo);
    }

    public function legalMoves(): array
    {
        return [
            'from e2 to e4' => ['e2', 'e4'],
            'from e2 to e3' => ['e2', 'e3'],
            'from d2 to d4' => ['d2', 'd4'],
        ];
    }

    /**
     * @test
     * @dataProvider legalMoves
     */
    public function moveAppliedIsCollectedIfMoveCanBeMade(string $from, string $to): void
    {
        $repo = new InMemoryBoardRepository(Stubber::boardWith(id: 'board-id', piecePosition: $from));
        $this->handler = new MakeMoveHandler($repo);

        $command = new MakeMove('board-id', $to);
        ($this->handler)($command);

        self::assertDomainEvents(
            new MoveApplied(Stubber::boardWith(id: 'board-id', moves: [$to], piecePosition: $to)),
        );
    }

    /**
     * @test
     */
    public function moveAppliedMoreThanOnceForConsectiveLegalMoves(): void
    {
        $repo = new InMemoryBoardRepository(Stubber::boardWith(id: 'board-id', piecePosition: 'e2'));
        $this->handler = new MakeMoveHandler($repo);
        $command = new MakeMove('board-id', 'e4');
        ($this->handler)($command);

        self::assertDomainEvents(
            new MoveApplied(Stubber::boardWith(id: 'board-id', moves: ['e4'], piecePosition: 'e4')),
        );

        $command = new MakeMove('board-id', 'e5');
        ($this->handler)($command);

        self::assertDomainEvents(
            new MoveApplied(Stubber::boardWith(id: 'board-id', moves: ['e4', 'e5'], piecePosition: 'e5')),
        );
    }

    /**
     * @test
     */
    public function moveAppliedMoreThanOnceForConsectiveLegalAndIllegalMoves(): void
    {
        $repo = new InMemoryBoardRepository(Stubber::boardWith(id: 'board-id', piecePosition: 'e2'));
        $this->handler = new MakeMoveHandler($repo);
        $command = new MakeMove('board-id', 'e4');
        ($this->handler)($command);

        self::assertDomainEvents(
            new MoveApplied(Stubber::boardWith(id: 'board-id', moves: ['e4'], piecePosition: 'e4')),
        );

        $command = new MakeMove('board-id', 'e6');
        ($this->handler)($command);

        self::expectException(IllegalMove::class);
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

    private static function assertDomainEvents(object ...$expected): void
    {
        self::assertEquals($expected, Events::popAll());
    }
}
