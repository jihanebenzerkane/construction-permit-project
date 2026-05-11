<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['nom' => 'Brouillon',                             'couleur' => '#6c757d'],
            ['nom' => 'Soumis',                                'couleur' => '#0d6efd'],
            ['nom' => "En cours d'étude",                      'couleur' => '#ffc107'],
            ['nom' => 'Documents complémentaires demandés',    'couleur' => '#fd7e14'],
            ['nom' => 'Validé techniquement',                  'couleur' => '#20c997'],
            ['nom' => 'Validé administrativement',             'couleur' => '#198754'],
            ['nom' => 'Refusé',                                'couleur' => '#dc3545'],
            ['nom' => 'Archivé',                               'couleur' => '#343a40'],
        ];

        foreach ($statuses as $s) {
            Status::firstOrCreate(['nom' => $s['nom']], ['couleur' => $s['couleur']]);
        }
    }
}