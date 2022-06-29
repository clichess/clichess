<?php

namespace CliChess\Board\PieceMoveValidity;

use CliChess\Board\Application\InMemoryBoardRepository;
use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use CliChess\Board\Domain\IllegalMove;
use CliChess\Board\Domain\MutatedAggregate;
use CliChess\Board\Domain\Pieces\Knight;
use CliChess\Board\Domain\Pieces\Pawn;
use CliChess\Board\Domain\Position;
use CliChess\Board\Domain\PositionedPiece;
use CliChess\Board\Domain\Square;
use CliChess\Board\Stubber;
use PHPUnit\Framework\TestCase;

class KnightMoveInAnEmptyBoardTest extends TestCase
{
    private MakeMoveHandler $handler;

    public function setUp(): void
    {
        $repo = new InMemoryBoardRepository(
            Stubber::boardWith(id: 'board-e3', initialPosition: new Position(new PositionedPiece(Square::fromString('e3'), new Knight()))),
            Stubber::boardWith(id: 'board-c6', initialPosition: new Position(new PositionedPiece(Square::fromString('c6'), new Knight()))),
        );

        $this->handler = new MakeMoveHandler($repo);
    }

    public function boardIdsWithLegalMoves(): array
    {
        return [
            'from e3 to f1' => ['board-e3', 'e3', 'f1'],
            'from e3 to g2' => ['board-e3', 'e3', 'g2'],
            'from e3 to g4' => ['board-e3', 'e3', 'g4'],
            'from e3 to f5' => ['board-e3', 'e3', 'f5'],
            'from e3 to d5' => ['board-e3', 'e3', 'd5'],
            'from e3 to c4' => ['board-e3', 'e3', 'c4'],
            'from e3 to c2' => ['board-e3', 'e3', 'c2'],
            'from e3 to d1' => ['board-e3', 'e3', 'd1'],

            'from c6 to a5' => ['board-c6', 'c6', 'a5'],
            'from c6 to b4' => ['board-c6', 'c6', 'b4'],
            'from c6 to d4' => ['board-c6', 'c6', 'd4'],
            'from c6 to e5' => ['board-c6', 'c6', 'e5'],
            'from c6 to e7' => ['board-c6', 'c6', 'e7'],
            'from c6 to d8' => ['board-c6', 'c6', 'd8'],
            'from c6 to b8' => ['board-c6', 'c6', 'b8'],
            'from c6 to a7' => ['board-c6', 'c6', 'a7'],
        ];
    }

    /**
     * @test
     * @dataProvider boardIdsWithLegalMoves
     */
    public function moveAppliedIsCollectedIfMoveCanBeMade(string $boardId, string $from, string $to): void
    {
        $command = new MakeMove($boardId, $to);

        ($this->handler)($command);

        self::assertMutatedAggregate(
            Stubber::boardWith(
                id: $boardId,
                initialPosition: new Position(new PositionedPiece(Square::fromString($from), new Knight())),
                moves: [$to],
            ),
        );

    }

    /**
     * @test
     */
    public function moveAppliedMoreThanOnceForConsecutiveLegalMoves(): void
    {
        ($this->handler)(new MakeMove('board-e3', 'g4'));
        ($this->handler)(new MakeMove('board-e3', 'h6'));
        ($this->handler)(new MakeMove('board-e3', 'f7'));
        ($this->handler)(new MakeMove('board-e3', 'd8'));

        self::assertMutatedAggregate(
            Stubber::boardWith(
                id: 'board-e3',
                initialPosition: new Position(
                    new PositionedPiece(Square::fromString('e3'), new Knight()),
                ),
                moves: ['g4', 'h6', 'f7', 'd8'],
            ),
        );
    }

    public function boardIdsWithIllegalMoves(): array
    {
        return [
            'from e3 to e5' => ['board-e3', 'e5'],
            'from e3 to e3' => ['board-e3', 'e3'],
            'from e3 to d5' => ['board-e3', 'd6'],
            'from e3 to h8' => ['board-e3', 'h8'],
            'from e3 to a1' => ['board-e3', 'a1'],
            'from e3 to d3' => ['board-e3', 'd3'],

            'from c6 to a1' => ['board-c6', 'a1'],
            'from c6 to b2' => ['board-c6', 'b2'],
            'from c6 to c3' => ['board-c6', 'c3'],
            'from c6 to d3' => ['board-c6', 'd3'],
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
