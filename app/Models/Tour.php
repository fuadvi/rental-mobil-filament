<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
