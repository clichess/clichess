<?php

namespace CliChess\Board\Application\PieceMoveValidity;

use CliChess\Board\Application\ApplicationTestCase;
use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\Position\IllegalMove;
use CliChess\Board\Stubber;

class BishopMoveInAnEmptyBoardTest extends ApplicationTestCase
{
    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            Stubber::boardWith(id: 'board-d4', initialPosition: ['d4' => 'B']),
            Stubber::boardWith(id: 'board-e4', initialPosition: ['e4' => 'B']),
        );

        $this->setUpHandler(new MakeMoveHandler($repo));
    }

    public function boardIdsWithLegalMoves(): array
    {
        return [
            'from d4 to e5' => ['board-d4', 'd4', 'e5'],
            'from d4 to a1' => ['board-d4', 'd4', 'a1'],
            'from d4 to a7' => ['board-d4', 'd4', 'a7'],
            'from d4 to g1' => ['board-d4', 'd4', 'g1'],
            'from d4 to f3' => ['board-d4', 'd4', 'f2'],
            'from d4 to f5' => ['board-d4', 'd4', 'f2'],
            'from d4 to h8' => ['board-d4', 'd4', 'h8'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithLegalMoves
     */
    public function boardIsCorrectlyMutatedIfMoveIsLegal(string $boardId, string $from, string $to): void
    {
        $expected = Stubber::boardWith(id: $boardId, initialPosition: [$from => 'B'], moves: [$to]);

        $this->callHandler(new MakeMove($boardId, $to));

        $this->assertMutatedAggregate($expected);
    }

    /**
     * @test
     */
    public function boardIsCorrectlyMutatedIfAllConsecutiveMovesAreLegal(): void
    {
        $expected = Stubber::boardWith(id: 'board-d4', initialPosition: ['d4' => 'B'], moves: ['g1', 'h2', 'b8']);

        $this->callHandler(new MakeMove('board-d4', 'g1'));
        $this->callHandler(new MakeMove('board-d4', 'h2'));
        $this->callHandler(new MakeMove('board-d4', 'b8'));

        $this->assertMutatedAggregate($expected);
    }

    public function boardIdsWithIllegalMoves(): array
    {
        return [
            'from e4 to e5' => ['board-e4', 'e5'],
            'from d4 to d1' => ['board-d4', 'f1'],
            'from d4 to d5' => ['board-d4', 'd5'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithIllegalMoves
     */
    public function throwExceptionIfMoveIsIllegal(string $boardId, string $to): void
    {
        self::expectException(IllegalMove::class);

        $this->callHandler(new MakeMove($boardId, $to));
    }
}
