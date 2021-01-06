<?php

namespace QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\Factory;

use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\FilterGroup;
use QuiqueGilB\GlobalApiCriteria\Shared\Filter\Domain\ValueObject\LogicalOperator;

class FilterGroupFactory
{

    public static function fromString(string $filter): FilterGroup
    {
        $groups = self::splitGroups($filter);
    }


    private static function splitGroups(string $filter): array
    {
        $length = strlen($filter);
        $parts = [];

        $charQuoted = null;
        $level = 0;
        $lastSpace = 0;
        $splitFrom = 0;
        $splitTo = 0;

        for ($i = 0; $i < $length; $i++) {
            $char = $filter[$i];

            if ('\\' === $char) {
                $i++;
                continue;
            }

            if ("'" === $char || '"' === $char) {
                $charQuoted = $charQuoted === $char ? null : $char;
            }

            if (null !== $charQuoted) {
                continue;
            }

            if ('(' === $char) {
                $level++;
                continue;
            }

            if (')' === $char) {
                $level--;
            }

            if (0 !== $level) {
                continue;
            }


            if ($i + 1 === $length) {
                $splitTo = $length;
            } elseif (' ' === $char) {
                $word = trim(substr($filter, $lastSpace, $i - $lastSpace));
                if (in_array($word, ['or', 'and'])) {
                    $splitTo = $lastSpace;
                }
                $lastSpace = $i;
            }

            if ($splitFrom === $splitTo) {
                continue;
            }

            $str = trim(substr($filter, $splitFrom, $splitTo - $splitFrom));
            [$operator, $filterExpression] = self::extract($str);

            $parts[] = [
                'logicOperator' => $operator,
                'filterExpression' => $filterExpression[0] === '('
                    ? self::splitGroups(substr($filterExpression, 1, strlen($filterExpression) - 2))
                    : $filterExpression
            ];

            $splitFrom = $splitTo + 1;
            $splitTo = $splitFrom;
        }


        if (0 !== $level) {
            throw new \Exception('Invalid groups');
        }

        if (null !== $charQuoted) {
            throw new \Exception('Invalid quotes');
        }
        return $parts;
    }

    private static function extract(string $filter): array
    {
        $firstSpace = strpos($filter, ' ');
        $firstWord = substr($filter, 0, $firstSpace);
        try {
            $logicalOperator = new LogicalOperator($firstWord);
            return [$logicalOperator->value(), trim(substr($filter, $firstSpace))];

        } catch (\Exception $e) {
            return [LogicalOperator:: AND, trim($filter)];
        }
    }
}
