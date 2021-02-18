<?php

namespace App\Models;

use App\Transformers\Snippets\SnippetTransformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Snippet extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function(Snippet $snippet) {
            $snippet->steps()->create([
                'order' => 1,
            ]);
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function toSearchableArray()
    {
        return fractal()
                ->item($this)
                ->transformWith(new SnippetTransformer())
                ->parseIncludes([
                    'author',
                    'steps'
                ])
                ->toArray();
    }

    public function isPublic()
    {
        return $this->is_public;
    }

    public function steps()
    {
        return $this->hasMany(Step::class)->orderBy('order', 'asc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublic(Builder $builder)
    {
        return $builder->where('is_public', true);
    }
}
