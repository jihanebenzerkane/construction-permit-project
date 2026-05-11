<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['citoyen', 'architecte', 'agent_urbanisme', 'service_technique', 'administrateur'] as $nom) {
            Role::firstOrCreate(['nom' => $nom]);
        }
    }
}