<?php

namespace CliChess\Board\Application\PieceMoveValidity;

use CliChess\Board\Application\ApplicationTestCase;
use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\Position\IllegalMove;
use CliChess\Board\Stubber;

class KingMoveInAnEmptyBoardTest extends ApplicationTestCase
{
    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            Stubber::boardWith(id: 'board-d4', initialPosition: ['d4' => 'K']),
        );

        $this->setUpHandler(new MakeMoveHandler($repo));
    }

    public function boardIdsWithLegalMoves(): array
    {
        return [
            'from d4 to d5' => ['board-d4', 'd4', 'd5'],
            'from d4 to e5' => ['board-d4', 'd4', 'e5'],
            'from d4 to e4' => ['board-d4', 'd4', 'e4'],
            'from d4 to e3' => ['board-d4', 'd4', 'e3'],
            'from d4 to d3' => ['board-d4', 'd4', 'd3'],
            'from d4 to c3' => ['board-d4', 'd4', 'c3'],
            'from d4 to c4' => ['board-d4', 'd4', 'c4'],
            'from d4 to c5' => ['board-d4', 'd4', 'c5'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithLegalMoves
     */
    public function boardIsCorrectlyMutatedIfMoveIsLegal(string $boardId, string $from, string $to): void
    {
        $expected = Stubber::boardWith(id: $boardId, initialPosition: [$from => 'K'], moves: [$to]);

        $this->callHandler(new MakeMove($boardId, $to));

        $this->assertMutatedAggregate($expected);
    }

    /**
     * @test
     */
    public function boardIsCorrectlyMutatedIfAllConsecutiveMovesAreLegal(): void
    {
        $expected = Stubber::boardWith(id: 'board-d4', initialPosition: ['d4' => 'K'], moves: ['d3', 'e2', 'f1']);

        $this->callHandler(new MakeMove('board-d4', 'd3'));
        $this->callHandler(new MakeMove('board-d4', 'e2'));
        $this->callHandler(new MakeMove('board-d4', 'f1'));

        $this->assertMutatedAggregate($expected);
    }

    public function boardIdsWithIllegalMoves(): array
    {
        return [
            'from d4 to e2' => ['board-d4', 'e2'],
            'from d4 to d6' => ['board-d4', 'd6'],
            'from d4 to f1' => ['board-d4', 'f1'],
            'from d4 to a1' => ['board-d4', 'a1'],
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
