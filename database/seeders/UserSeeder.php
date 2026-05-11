<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $district = District::first();

        $users = [
            ['email' => 'citoyen@test.com',   'role' => 'citoyen',           'nom' => 'Alami',   'prenom' => 'Youssef', 'cin' => 'AB123456'],
            ['email' => 'architecte@test.com', 'role' => 'architecte',        'nom' => 'Benali',  'prenom' => 'Sara',    'cin' => 'CD234567'],
            ['email' => 'agent@test.com',      'role' => 'agent_urbanisme',   'nom' => 'Karimi',  'prenom' => 'Omar',    'cin' => 'EF345678'],
            ['email' => 'technique@test.com',  'role' => 'service_technique', 'nom' => 'Idrissi', 'prenom' => 'Leila',   'cin' => 'GH456789'],
            ['email' => 'admin@test.com',      'role' => 'administrateur',    'nom' => 'Admin',   'prenom' => 'Super',   'cin' => 'IJ567890'],
        ];

        foreach ($users as $u) {
            $role = Role::where('nom', $u['role'])->first();
            User::firstOrCreate(['email' => $u['email']], [
                'nom'         => $u['nom'],
                'prenom'      => $u['prenom'],
                'password'    => Hash::make('password'),
                'cin'         => $u['cin'],
                'role_id'     => $role?->id,
                'district_id' => $district?->id,
            ]);
        }
    }
}