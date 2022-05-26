<?php

namespace CliChess\Board;

use CliChess\Board\Domain\Board;
use CliChess\Board\Domain\BoardId;
use CliChess\Board\Domain\Move;
use CliChess\Board\Domain\Pawn;
use CliChess\Board\Domain\Square;
use ReflectionClass;

final class Stubber
{
    public static function boardWith(
        string $id = null,
        string $piecePosition = null,
        array $moves = [],
    ): Board {
        return self::hydrate(Board::class, [
            'id' => new BoardId($id ?? '666'),
            'piece' => new Pawn(Square::fromString($piecePosition ?? 'e4')),
            'moves' => array_map(
                fn (string $m): Move => new Move($m),
                $moves,
            ),
        ]);
    }

    /**
     * @template T
     * @param class-string<T> $class
     * @return T
     */
    private static function hydrate(string $class, array $map): object
    {
        $rClass = new ReflectionClass($class);
        $instance = $rClass->newInstanceWithoutConstructor();

        foreach ($map as $property => $value) {
            $rProp = $rClass->getProperty($property);
            $rProp->setAccessible(true);
            $rProp->setValue($instance, $value);
        }

        return $instance;
    }

}