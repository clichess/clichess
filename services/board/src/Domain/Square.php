<?php

namespace CliChess\Board\Domain;

use InvalidArgumentException;

final class Square
{
    private const LEGAL_ROWS = ['1', '2', '3', '4', '5', '6', '7', '8'];
    private const LEGAL_COLUMNS = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    private readonly string $value;

    private function __construct(string $value) 
    {
        if (2 !== strlen($value) || !in_array($value[0], self::LEGAL_COLUMNS) || !in_array($value[1], self::LEGAL_ROWS)) {
            throw new InvalidArgumentException("Invalid square $value");
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
