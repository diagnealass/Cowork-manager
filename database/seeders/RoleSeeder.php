<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ManagerProfile;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin System',
            'email' => 'admin@cowork.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // 2. Manager avec profil
        $manager1 = User::create([
            'name' => 'Marie Dupont',
            'email' => 'marie@cowork.com',
            'password' => bcrypt('password'),
            'phone_number' => '+33 6 12 34 56 78',
            'company_name' => 'CoWork Paris SARL',
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        ManagerProfile::create([
            'user_id' => $manager1->id,
            'bio' => 'Gestionnaire d\'espaces de coworking depuis 10 ans à Paris.',
            'company_registration' => '123 456 789 00012',
            'tax_id' => 'FR 12 345678901',
            'verified_at' => now(),
        ]);

        // 3. Manager 2
        $manager2 = User::create([
            'name' => 'Thomas Martin',
            'email' => 'thomas@cowork.com',
            'password' => bcrypt('password'),
            'phone_number' => '+33 6 98 76 54 32',
            'company_name' => 'Lyon Coworking',
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        ManagerProfile::create([
            'user_id' => $manager2->id,
            'bio' => 'Entrepreneur passionné, spécialisé dans les espaces de travail innovants.',
            'company_registration' => '987 654 321 00045',
            'tax_id' => 'FR 98 765432109',
            'verified_at' => now(),
        ]);

        // 4-8. Clients
        $clients = [
            ['name' => 'Paul Bernard', 'email' => 'paul@mail.com'],
            ['name' => 'Sophie Laurent', 'email' => 'sophie@mail.com'],
            ['name' => 'Lucas Petit', 'email' => 'lucas@mail.com'],
            ['name' => 'Emma Dubois', 'email' => 'emma@mail.com'],
            ['name' => 'Hugo Moreau', 'email' => 'hugo@mail.com'],
        ];

        foreach ($clients as $client) {
            User::create([
                'name' => $client['name'],
                'email' => $client['email'],
                'password' => bcrypt('password'),
                'role' => 'client',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }
    }
}
