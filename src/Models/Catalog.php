<?php

namespace Mortezaa97\Catalogs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Mortezaa97\Shop\Models\Product;
use App\Models\User;

class Catalog extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    protected $appends = [];
    protected $with = [];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderByDesc('created_at');
        });
    }



    /*
    * Relations
    */
    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function items($itemType): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphedByMany(related: $itemType, name: 'model', table: 'model_has_catalogs')
                ->withoutGlobalScopes()
                ->withPivot('sort')
                ->reorder('model_has_catalogs.sort');
    }
}
