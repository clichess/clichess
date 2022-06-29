<?php

namespace CliChess\Board\Application;

use CliChess\Board\Domain\MutatedAggregate;
use PHPUnit\Framework\TestCase;

abstract class ApplicationTestCase extends TestCase
{
    /** @var callable */ private $handler;

    protected function setUpHandler(callable $handler): void
    {
        $this->handler = $handler;
    }

    protected function callHandler(object $message): void
    {
        ($this->handler)($message);
    }

    protected function assertMutatedAggregate(object $expected): void
    {
        $this->assertEquals($expected, MutatedAggregate::pop());
    }
}
