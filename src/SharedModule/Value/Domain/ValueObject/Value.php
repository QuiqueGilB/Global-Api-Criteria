<?php

namespace QuiqueGilB\GlobalApiCriteria\SharedModule\Value\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\SharedModule\Utils\Domain\Helper\StringHelper;

class Value
{
    private $value;
    private $type;

    public function __construct(string $value)
    {
        $this->value = trim($value);
        $this->type = ValueType::fromValue($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function type(): ValueType
    {
        return $this->type;
    }

    public function scalar()
    {
        if ($this->type->isBoolean()) {
            return $this->value === 'true';
        }

        if ($this->type->isNull()) {
            return null;
        }

        if ($this->type->isInt()) {
            return (int)$this->value;
        }

        if ($this->type->isDecimal()) {
            return (float)$this->value;
        }

        if($this->type->isArray()) {
            return array_map(
                static function ($item) {
                    return self::deserialize($item)->scalar();
                },
                StringHelper::split($this->value)
            );
        }

        return StringHelper::unquote($this->value);
    }

    public static function deserialize(string $value): self
    {
        return new static($value);
    }

    public function serialize(): string
    {
        return $this->value;
    }
}
