<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Application\Query\Product;

use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Data\Domain\ValueObject\QueryData;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\Metadata\Domain\ValueObject\QueryMetadata;
use QuiqueGilB\GlobalApiCriteria\QueryResponseModule\QueryResponse\Domain\ValueObject\QueryResponse;

class SearchProductsQueryHandler
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function __invoke(SearchProductsQuery $query): QueryResponse
    {
        $products = $this->productRepository->querySearch($query->criteria());
        $countProducts = $this->productRepository->queryCount($query->criteria());

        return new QueryResponse(
            new QueryData($products),
            new QueryMetadata(
                $query->criteria()->paginate()->offset()->value(),
                $query->criteria()->paginate()->limit()->value(),
                $countProducts
            )
        );
    }
}
