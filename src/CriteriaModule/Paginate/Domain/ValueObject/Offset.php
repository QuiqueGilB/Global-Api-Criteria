<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Paginate\Domain\Exception\InvalidOffsetException;

class Offset
{
    private $value;

    public function __construct(int $offset)
    {
        self::validate($offset);
        $this->value = $offset;
    }

    public static function validate(int $offset): void
    {
        if (0 > $offset) {
            throw new InvalidOffsetException($offset);
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isZero(): bool
    {
        return 0 === $this->value;
    }
}
