<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\User\User\Domain\Criteria;

use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\Criteria;
use QuiqueGilB\GlobalApiCriteria\Criteria\Criteria\Domain\ValueObject\FieldCriteriaRules;
use QuiqueGilB\GlobalApiCriteria\Criteria\Filter\Domain\ValueObject\ComparisonOperator;

class ProductCriteriaExample extends Criteria
{
    protected static function createRules(): array
    {
        return [
            FieldCriteriaRules::create('id')
                ->sortable(false)
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::in()
                ),
            FieldCriteriaRules::create('name')
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::like(),
                ),
            FieldCriteriaRules::create('stock')
                ->comparisonOperators(
                    ComparisonOperator::greater(),
                    ComparisonOperator::greaterOrEqual(),
                    ComparisonOperator::less(),
                    ComparisonOperator::lessOrEqual()
                ),
            FieldCriteriaRules::create('count_sales'),
            FieldCriteriaRules::create('category')
                ->sortable(false)
                ->comparisonOperators(
                    ComparisonOperator::equal(),
                    ComparisonOperator::in()
                )
            ,

        ];
    }
}