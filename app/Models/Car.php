<?php

namespace App\Models;

use App\Models\Tour;
use App\Models\LeaseType;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset(Storage::url($value)),
        );
    }
}
