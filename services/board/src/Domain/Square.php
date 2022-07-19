<?php

namespace CliChess\Board\Domain;

use InvalidArgumentException;

final class Square
{
    private readonly string $value;

    private function __construct(string $value) 
    {
        if (!in_array($value[0], range('a', 'h')) || !in_array($value[1], range(1, 8))) {
            throw new InvalidArgumentException(
                sprintf('Invalid square %s', $value)
            );
        }

        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function column(): string
    {
        return $this->value[0];
    }

    public function row(): string
    {
        return $this->value[1];
    }
}
