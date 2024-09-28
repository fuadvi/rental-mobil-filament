<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Car extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

     /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'cars_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'title' =>  $this->title,
        ];
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($car) {
         $car->slug = Str::slug($car->title);
        });
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'car_tours');
    }

    public function leaseTypes(): BelongsToMany
    {
        return $this->belongsToMany(LeaseType::class, 'car_lease_types');
    }
}
