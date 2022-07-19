<?php

namespace CliChess\Board\Application;

use CliChess\Board\Application\Move\MakeMove;
use CliChess\Board\Application\Move\MakeMoveHandler;
use InvalidArgumentException;

class DoNotAcceptMovesToInvalidSquareTest extends ApplicationTestCase
{
    public function setUp(): void
    {
        $this->setUpHandler(new MakeMoveHandler(new InMemoryBoardRepository()));
    }

    public function invalidSquare(): array
    {
        return [
            'z1' => ['z1'],
            'a0' => ['a0'],
            'a9' => ['a9'],
            'ab' => ['ab'],
            'abc' => ['abc'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidSquare
     */
    public function boardIsCorrectlyMutatedIfAllConsecutiveMovesAreLegal(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->callHandler(new MakeMove('board-id', 'z1'));
    }
}
