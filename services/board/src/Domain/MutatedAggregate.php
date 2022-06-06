<?php

namespace CliChess\Board\Domain;

final class MutatedAggregate
{
    private static ?self $singleton = null;
    private ?object $aggregate = null;

    private function __construct()
    {
    }

    public static function add(object $aggregate): void
    {
        self::instance()->aggregate = $aggregate;
    }

    public static function pop(): ?object
    {
        $aggregate = self::instance()->aggregate;

        self::instance()->aggregate = null;

        return $aggregate;
    }

    private static function instance(): self
    {
        return self::$singleton ?? self::$singleton = new self();
    }
}

