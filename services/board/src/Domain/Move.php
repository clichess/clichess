<?php

namespace CliChess\Board\Domain;

use InvalidArgumentException;

final class Move
{
    public function __construct(
        public readonly string $value,
    ) {
        if (2 !== strlen($this->value)) {
            throw new InvalidArgumentException();
        }
    }
}
