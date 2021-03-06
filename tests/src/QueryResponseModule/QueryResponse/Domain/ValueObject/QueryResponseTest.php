<?php

namespace QuiqueGilB\GlobalApiCriteria\Tests\QueryResponseModule\QueryResponse\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\QueryResponse\Domain\Exception\InvalidQueryResponseException;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\QueryResponse\Domain\ValueObject\QueryResponse;

class QueryResponseTest extends TestCase
{
    /** @test */
    public function assert_invalid_instances(): void
    {
        $this->expectException(InvalidQueryResponseException::class);
        QueryResponse::create(QueryData::create(['abc','def']), QueryMetadata::create(5, 10, 2));
    }

    /** @test */
    public function assert_valid_instances(): void
    {
        $this->expectNotToPerformAssertions();
        QueryResponse::create(QueryData::create([]), QueryMetadata::create(5, 10, 0));
        QueryResponse::create(QueryData::create(null), QueryMetadata::create(5, 10, 0));
        QueryResponse::create(QueryData::create(['abc', 'def']), QueryMetadata::create(1, 10, 3));
        QueryResponse::create(QueryData::create('abc'), QueryMetadata::create(5, 10, 6));
        QueryResponse::create(QueryData::create(['a' => 'b', 'c' => 'd']), QueryMetadata::create(1, 10, 2));
    }
}
