<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shop_id',
        'title',
        'details',
        'sorting'
    ];

    /**
     * Retrieves the Shop model that this belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * The Boot function for sorting
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->sorting = self::max('sorting') + 1;
        });
    }

    /**
     * The sorted function for sorting
     */
    public function scopeSorted($query)
    {
        return $query->orderBy('sorting', 'asc');
    }

}