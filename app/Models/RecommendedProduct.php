<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $product_id
 * @property int $recommended_product_id
 * @method static Builder<static>|RecommendedProduct newModelQuery()
 * @method static Builder<static>|RecommendedProduct newQuery()
 * @method static Builder<static>|RecommendedProduct query()
 * @method static Builder<static>|RecommendedProduct whereProductId($value)
 * @method static Builder<static>|RecommendedProduct whereRecommendedProductId($value)
 * @mixin Eloquent
 */
class RecommendedProduct extends Model
{
    protected $fillable = [
        'product_id',
        'recommended_product_id',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'recommended_product_id');
    }
}
