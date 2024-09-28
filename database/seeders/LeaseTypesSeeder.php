<?php

namespace Database\Seeders;

use App\Models\LeaseType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSewa = [
          [
            "id" => 1,
            "title" => "Tarif Drop Bandara",
            "description" => "antar jemput ke bandara"
          ]
        ];

        LeaseType::insert($jenisSewa);
    }
}
