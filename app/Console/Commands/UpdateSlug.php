<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\LeaseType;
use App\Models\Tour;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update slug in all app';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      Car::all()->each(function ($car) {
        $car->update(['slug' => Str::slug($car->title)]);
      });

      Tour::all()->each(function ($tour) {
        $tour->update(['slug' => Str::slug($tour->title)]);
      });

      LeaseType::all()->each(function ($leaseType) {
        $leaseType->update(['slug' => Str::slug($leaseType->title)]);
      });
    }
}
