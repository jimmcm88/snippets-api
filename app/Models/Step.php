<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Step extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function(Step $step) {
            $step->uuid = Str::uuid();
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

    public function snippet()
    {
        return $this->belongsTo(Snippet::class);
    }

    public function afterOrder()
    {
        $adjacentStep = self::where('order', '>', $this->order)
                            ->orderBy('order', 'asc')
                            ->first();

        if (!$adjacentStep) {
            return self::orderBy('order', 'desc')->first()->order + 1;
        }

        return ($this->order + $adjacentStep->order) / 2;
    }

    public function beforeOrder()
    {
        $adjacentStep = self::where('order', '<', $this->order)
                            ->orderBy('order', 'desc')
                            ->first();

        if (!$adjacentStep) {
            return self::orderBy('order', 'asc')->first()->order - 1;
        }

        return ($this->order + $adjacentStep->order) / 2;
    }
}
