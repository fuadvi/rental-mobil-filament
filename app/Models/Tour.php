<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Tour extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function carTour()
    {
      return $this->belongsTo(CarTour::class, 'tour_id','id');
    }

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_tours');
    }

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($tour) {
        $tour->slug = Str::slug($tour->title);
      });

      static::updating(function (Tour $tour) {
        $tour->slug = Str::slug($tour->title);

        if (!$tour->attributes['image']) $tour->image = $tour->original['image'];
      });
    }

    protected function image(): Attribute
    {
      return Attribute::make(
        get: fn ($value) => asset(Storage::url($value)),
      );
    }

     /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'tours_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'title' =>  $this->title,
        ];
    }

}
