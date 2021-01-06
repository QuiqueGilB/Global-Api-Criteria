<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject;

use PHPUnit\Util\Exception;

class LogicalOperator
{
    public const AND = 'and';
    public const OR = 'or';
//    public const NOT = 'not';


    private const MAP = [
        "&&" => self:: AND,
        "and" => self:: AND,

        "||" => self:: OR,
        "or" => self:: OR,

//        "not" => self::NOT,
    ];

    private $value;

    public function __construct(string $operator)
    {
        self::validate($operator);
        $this->value = $operator;
    }

    public static function validate(string $operator): void
    {
        if (!in_array($operator, array_keys(self::MAP))) {
            throw new Exception('Invalid logical operator');
        }
    }

    public static function and(): self
    {
        return new static(self:: AND);
    }

    public static function or(): self
    {
        return new static(self:: OR);
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function acceptedValues(): array
    {
        return array_keys(self::MAP);
    }
}
