<?php

namespace CliChess\Board\Domain;

final class Events
{
    private static ?self $singleton = null;
    /** @var object[] */ private array $events = [];

    private function __construct()
    {
    }

    public static function collect(object $event): void
    {
        self::instance()->events[] = $event;
    }

    public static function popAll(): array
    {
        $events = self::instance()->events;

        self::instance()->events = [];

        return $events;
    }

    private static function instance(): self
    {
        return self::$singleton ?? self::$singleton = new self();
    }
}

