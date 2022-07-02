<?php

namespace CliChess\Board;

use CliChess\Board\Domain\Board;
use CliChess\Board\Domain\BoardId;
use CliChess\Board\Domain\Move;
use CliChess\Board\Domain\Position\Position;
use ReflectionClass;

final class Stubber
{
    public static function boardWith(
        string $id = null,
        array $moves = [],
        array $initialPosition = [],
    ): Board {
        return self::hydrate(Board::class, [
            'id' => new BoardId($id ?? '666'),
            'initialPosition' => Position::fromRawArray($initialPosition),
            'moves' => array_map(fn (string $m): Move => new Move($m), $moves),
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