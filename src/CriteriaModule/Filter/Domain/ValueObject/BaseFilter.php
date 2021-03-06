<?php

namespace QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\ValueObject;

use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Domain\Exception\LogicalOperatorViolationException;

abstract class BaseFilter
{
    private $logicalOperator;

    public function logicalOperator(): LogicalOperator
    {
        return $this->logicalOperator ?? LogicalOperator::and();
    }

    protected function setLogicOperator(LogicalOperator $logicalOperator): self
    {
        if (null !== $this->logicalOperator) {
            throw new LogicalOperatorViolationException('Not possible modify logical operator');
        }

        $this->logicalOperator = $logicalOperator;
        return $this;
    }
}
