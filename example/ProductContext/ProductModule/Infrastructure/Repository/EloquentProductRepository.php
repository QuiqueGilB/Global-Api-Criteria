<?php

namespace QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Builder;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Criteria\Application\Apply\EloquentApplyCriteria;
use QuiqueGilB\GlobalApiCriteria\CriteriaModule\Filter\Application\Apply\EloquentApplyFilter;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Criteria\ProductCriteriaExample;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\Product;
use QuiqueGilB\GlobalApiCriteria\Example\ProductContext\ProductModule\Domain\Model\ProductRepository;
use QuiqueGilB\GlobalApiCriteria\Example\SharedContext\SharedModule\Infrastructure\Eloquent\EloquentRepository;

class EloquentProductRepository extends EloquentRepository implements ProductRepository
{
    public function byId(int $productId):?Product
    {
        return EloquentProductModel::find($productId)->cast();
    }

    public function querySearch(ProductCriteriaExample $productCriteria): array
    {
        $builder = self::createQueryBuilder($productCriteria);
        EloquentApplyCriteria::apply($builder, $productCriteria, self::mapCriteriaFields());
        return $this->castResult($builder->get()->all());
    }

    public function queryCount(ProductCriteriaExample $productCriteria): int
    {
        $builder = self::createQueryBuilder($productCriteria);
        EloquentApplyFilter::apply($builder, $productCriteria->filters(), self::mapCriteriaFields());
        return $builder->count();
    }

    private static function createQueryBuilder(ProductCriteriaExample $productCriteria): Builder
    {
        $builder = EloquentProductModel::query()
            ->select('product.*');

        if ($productCriteria->hasField('category')) {
            $builder->join(
                'category_product',
                'category_product.product_id',
                '=',
                'product.id'
            );
            $builder->join(
                'category',
                'category.id',
                '=',
                'category_product.category_id'
            );
        }

        return $builder;
    }

    private static function mapCriteriaFields(): array
    {
        return [
            'category' => 'category.id'
        ];
    }
}
