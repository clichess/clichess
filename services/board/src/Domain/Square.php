<?php

namespace CliChess\Board\Domain;

enum Square: string
{
    case d2 = 'd2';
    case d4 = 'd4';

    case e2 = 'e2';
    case e3 = 'e3';
    case e4 = 'e4';
    case e5 = 'e5';
    case e6 = 'e6';

    public static function fromString(string $value): self
    {
        return self::tryFrom($value);
    }

    public function columnDiff(self $that): int
    {
        return ord($this->column()) - ord($that->column());
    }

    public function rowDiff(self $that): int
    {
        return ord($this->row()) - ord($that->row());
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