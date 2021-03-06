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

    public function columnDiff(self $that): int
    {
        return ord($this->column()) - ord($that->column());
    }

    public function rowDiff(self $that): int
    {
        return ord($this->row()) - ord($that->row());
    }

    public function onSameRowAs(self $that): int
    {
        return 0 === $this->rowDiff($that);
    }

    public function onSameColumnAs(self $that): int
    {
        return 0 === $this->columnDiff($that);
    }

    public function inDiagonalWith(self $that): bool
    {
        $rowDiff = $this->rowDiff($that);
        $columnDiff = $this->columnDiff($that);

        return abs($rowDiff) === abs($columnDiff);
    }

    private function column(): string
    {
        return $this->value[0];
    }

    private function row(): string
    {
        return $this->value[1];
    }
}
