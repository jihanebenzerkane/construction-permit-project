<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermitType;

class PermitTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Résidentiel', 'Commercial', 'Industriel', 'Agricole', 'Infrastructure'];
        foreach ($types as $nom) {
            PermitType::firstOrCreate(['nom' => $nom]);
        }
    }
}