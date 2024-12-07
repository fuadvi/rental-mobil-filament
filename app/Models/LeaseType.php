<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class LeaseType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_lease_types');
    }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($leaseType) {
      $leaseType->slug = Str::slug($leaseType->title);
    });

    static::updating(function ($leaseType) {
      $leaseType->slug = Str::slug($leaseType->title);
    });
  }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset(Storage::url($value)),
        );
    }
}
