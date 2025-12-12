<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use Illuminate\Support\Str;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            // Connectivity
            ['name' => 'WiFi Haut Débit', 'category' => 'connectivity', 'icon' => 'wifi'],
            ['name' => 'Ethernet Gigabit', 'category' => 'connectivity', 'icon' => 'ethernet'],

            // Equipment
            ['name' => 'Imprimante', 'category' => 'equipment', 'icon' => 'printer'],
            ['name' => 'Scanner', 'category' => 'equipment', 'icon' => 'scanner'],
            ['name' => 'Projecteur', 'category' => 'equipment', 'icon' => 'projector'],
            ['name' => 'Tableau Blanc', 'category' => 'equipment', 'icon' => 'whiteboard'],
            ['name' => 'Écran TV', 'category' => 'equipment', 'icon' => 'tv'],

            // Comfort
            ['name' => 'Café Gratuit', 'category' => 'comfort', 'icon' => 'coffee'],
            ['name' => 'Climatisation', 'category' => 'comfort', 'icon' => 'air-conditioner'],
            ['name' => 'Chauffage', 'category' => 'comfort', 'icon' => 'heater'],
            ['name' => 'Cuisine Équipée', 'category' => 'comfort', 'icon' => 'kitchen'],
            ['name' => 'Réfrigérateur', 'category' => 'comfort', 'icon' => 'fridge'],
            ['name' => 'Micro-ondes', 'category' => 'comfort', 'icon' => 'microwave'],

            // Services
            ['name' => 'Parking', 'category' => 'services', 'icon' => 'car'],
            ['name' => 'Accès 24/7', 'category' => 'services', 'icon' => 'clock'],
            ['name' => 'Accueil/Réception', 'category' => 'services', 'icon' => 'reception'],
            ['name' => 'Service de Ménage', 'category' => 'services', 'icon' => 'cleaning'],
            ['name' => 'Casiers Sécurisés', 'category' => 'services', 'icon' => 'locker'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create([
                'name' => $amenity['name'],
                'slug' => Str::slug($amenity['name']),
                'category' => $amenity['category'],
                'icon' => $amenity['icon'],
            ]);
        }
    }
}
