<?php

namespace CliChess\Board\Application\PieceMoveValidity;

use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\MutatedAggregate;
use CliChess\Board\Domain\Position\IllegalMove;
use CliChess\Board\Stubber;
use PHPUnit\Framework\TestCase;

class PawnMoveInAnEmptyBoardTest extends TestCase
{
    private MakeMoveHandler $handler;

    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            Stubber::boardWith(id: 'board-e2', initialPosition: ['e2' => 'P']),
            Stubber::boardWith(id: 'board-d2', initialPosition: ['d2' => 'P']),
        );

        $this->handler = new MakeMoveHandler($repo);
    }

    public function boardIdsWithLegalMoves(): array
    {
        return [
            'from e2 to e4' => ['board-e2', 'e2', 'e4'],
            'from e2 to e3' => ['board-e2', 'e2', 'e3'],
            'from d2 to d4' => ['board-d2', 'd2', 'd4'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithLegalMoves
     */
    public function boardIsCorrectlyMutatedIfMoveIsLegal(string $boardId, string $from, string $to): void
    {
        $expected = Stubber::boardWith(id: $boardId, initialPosition: [$from => 'P'], moves: [$to]);

        ($this->handler)(new MakeMove($boardId, $to));

        self::assertMutatedAggregate($expected);
    }

    /**
     * @test
     */
    public function boardIsCorrectlyMutatedIfAllConsecutiveMovesAreLegal(): void
    {
        $expected = Stubber::boardWith(id: 'board-e2', initialPosition: ['e2' => 'P'], moves: ['e4', 'e5', 'e6']);

        ($this->handler)(new MakeMove('board-e2', 'e4'));
        ($this->handler)(new MakeMove('board-e2', 'e5'));
        ($this->handler)(new MakeMove('board-e2', 'e6'));

        self::assertMutatedAggregate($expected);
    }

    public function boardIdsWithIllegalMoves(): array
    {
        return [
            'from e2 to e5' => ['board-e2', 'e5'],
            'from d2 to e3' => ['board-d2', 'e3'],
            'from d2 to d5' => ['board-d2', 'd5'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithIllegalMoves
     */
    public function throwExceptionIfMoveIsIllegal(string $boardId, string $to): void
    {
        $command = new MakeMove($boardId, $to);

        self::expectException(IllegalMove::class);

        ($this->handler)($command);
    }

    private static function assertMutatedAggregate(object $expected): void
    {
        self::assertEquals($expected, MutatedAggregate::pop());
    }
}
