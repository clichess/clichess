<?php

namespace CliChess\Board\Domain;

final class BoardId
{
    public function __construct(
        public readonly string $value,
    ) {
    }

    public function equalTo(self $that): bool
    {
        return $this->value === $that->value;
    }
}
