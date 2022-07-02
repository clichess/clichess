<?php

namespace CliChess\Board\Application\PieceMoveValidity;

use CliChess\Board\Application\ApplicationTestCase;
use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\Position\IllegalMove;
use CliChess\Board\Stubber;

class RookMoveInAnEmptyBoardTest extends ApplicationTestCase
{
    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            Stubber::boardWith(id: 'board-a4', initialPosition: ['a4' => 'R']),
            Stubber::boardWith(id: 'board-e5', initialPosition: ['e5' => 'R']),
        );

        $this->setUpHandler(new MakeMoveHandler($repo));
    }

    public function boardIdsWithLegalMoves(): array
    {
        return [
            'from a4 to c4' => ['board-a4', 'a4', 'c4'],
            'from a4 to d4' => ['board-a4', 'a4', 'd4'],
            'from a4 to a7' => ['board-a4', 'a4', 'a7'],
            'from a4 to a2' => ['board-a4', 'a4', 'a2'],
            'from a4 to b4' => ['board-a4', 'a4', 'b4'],
            'from e5 to f5' => ['board-e5', 'e5', 'f5'],
            'from e5 to e7' => ['board-e5', 'e5', 'e7'],
            'from e5 to e1' => ['board-e5', 'e5', 'e1'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithLegalMoves
     */
    public function boardIsCorrectlyMutatedIfMoveIsLegal(string $boardId, string $from, string $to): void
    {
        $expected = Stubber::boardWith(id: $boardId, initialPosition: [$from => 'R'], moves: [$to]);

        $this->callHandler(new MakeMove($boardId, $to));

        $this->assertMutatedAggregate($expected);
    }

    /**
     * @test
     */
    public function boardIsCorrectlyMutatedIfAllConsecutiveMovesAreLegal(): void
    {
        $expected = Stubber::boardWith(id: 'board-e5', initialPosition: ['e5' => 'R'], moves: ['e3', 'd3', 'd1']);

        $this->callHandler(new MakeMove('board-e5', 'e3'));
        $this->callHandler(new MakeMove('board-e5', 'd3'));
        $this->callHandler(new MakeMove('board-e5', 'd1'));

        $this->assertMutatedAggregate($expected);
    }

    public function boardIdsWithIllegalMoves(): array
    {
        return [
            'from e5 to h1' => ['board-e5', 'h1'],
            'from a4 to g3' => ['board-a4', 'g3'],
            'from a4 to b3' => ['board-a4', 'b3'],
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
