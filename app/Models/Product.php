<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property int $frequency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Product newModelQuery()
 * @method static Builder<static>|Product newQuery()
 * @method static Builder<static>|Product query()
 * @method static Builder<static>|Product whereCreatedAt($value)
 * @method static Builder<static>|Product whereFrequency($value)
 * @method static Builder<static>|Product whereId($value)
 * @method static Builder<static>|Product whereName($value)
 * @method static Builder<static>|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    protected $fillable = [
        'name',
        'frequency'
    ];

    public function recommended(): HasManyThrough
    {
        return $this->hasManyThrough(
            RecommendedProduct::class,
            Product::class,
            'id'
        );
    }
}
