<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Space;
use App\Models\User;
use App\Models\Amenity;
use App\Models\SpaceImage;
use App\Models\BusinessHour;

class SpaceSeeder extends Seeder
{
    public function run(): void
    {
        $managers = User::where('role', 'manager')->get();
        $amenities = Amenity::all();

        $spaces = [
            [
                'name' => 'Bureau Downtown Paris',
                'description' => 'Magnifique bureau privé de 20m² au cœur de Paris. Vue sur la Seine. Idéal pour 2-3 personnes. Accès 24/7 avec badge sécurisé.',
                'city' => 'Paris',
                'postal_code' => '75001',
                'address' => '15 Rue de Rivoli',
                'capacity' => 3,
                'type' => 'private_office',
                'price_per_hour' => 15.00,
                'price_per_day' => 100.00,
                'price_per_month' => 2000.00,
            ],
            [
                'name' => 'Salle de Réunion Premium',
                'description' => 'Salle de réunion moderne équipée d\'un projecteur 4K, tableau blanc interactif et système de visioconférence professionnel.',
                'city' => 'Paris',
                'postal_code' => '75008',
                'address' => '25 Avenue des Champs-Élysées',
                'capacity' => 12,
                'type' => 'meeting_room',
                'price_per_hour' => 50.00,
                'price_per_day' => 300.00,
                'price_per_month' => null,
            ],
            [
                'name' => 'Open Space Créatif Lyon',
                'description' => 'Espace de coworking ouvert et lumineux dans le quartier de la Part-Dieu. Ambiance startup, événements networking réguliers.',
                'city' => 'Lyon',
                'postal_code' => '69003',
                'address' => '10 Rue de la République',
                'capacity' => 30,
                'type' => 'shared_desk',
                'price_per_hour' => 5.00,
                'price_per_day' => 30.00,
                'price_per_month' => 500.00,
            ],
            [
                'name' => 'Bureau Privé Bordeaux',
                'description' => 'Bureau calme et élégant dans le centre historique de Bordeaux. Parfait pour le télétravail ou consultations clients.',
                'city' => 'Bordeaux',
                'postal_code' => '33000',
                'address' => '5 Place de la Bourse',
                'capacity' => 2,
                'type' => 'private_office',
                'price_per_hour' => 12.00,
                'price_per_day' => 80.00,
                'price_per_month' => 1500.00,
            ],
            [
                'name' => 'Espace Complet Startup',
                'description' => 'Étage complet privatisable pour équipes de 15-20 personnes. Bureaux privés + open space + salle de réunion. Fibre 1Gbps.',
                'city' => 'Paris',
                'postal_code' => '75011',
                'address' => '50 Rue Oberkampf',
                'capacity' => 20,
                'type' => 'entire_space',
                'price_per_hour' => null,
                'price_per_day' => 500.00,
                'price_per_month' => 8000.00,
            ],
        ];

        foreach ($spaces as $index => $spaceData) {
            $manager = $managers[$index % $managers->count()];

            $space = Space::create([
                'manager_id' => $manager->id,
                'name' => $spaceData['name'],
                'description' => $spaceData['description'],
                'address' => $spaceData['address'],
                'city' => $spaceData['city'],
                'country' => 'France',
                'postal_code' => $spaceData['postal_code'],
                'capacity' => $spaceData['capacity'],
                'space_type' => $spaceData['type'],
                'price_per_hour' => $spaceData['price_per_hour'],
                'price_per_day' => $spaceData['price_per_day'],
                'price_per_month' => $spaceData['price_per_month'],
                'currency' => 'EUR',
                'is_active' => true,
                'is_featured' => $index < 2, // Les 2 premiers sont mis en avant
            ]);

            // Attacher 4-6 amenities aléatoires
            $randomAmenities = $amenities->random(rand(4, 6));
            $space->amenities()->attach($randomAmenities);

            // Créer 3 images
            for ($i = 1; $i <= 3; $i++) {
                SpaceImage::create([
                    'space_id' => $space->id,
                    'image_path' => "spaces/space-{$space->id}-{$i}.jpg",
                    'is_primary' => $i === 1,
                    'order' => $i,
                ]);
            }

            // Créer les horaires (Lundi-Vendredi 9h-18h, Samedi 10h-16h)
            for ($day = 1; $day <= 5; $day++) {
                BusinessHour::create([
                    'space_id' => $space->id,
                    'day_of_week' => $day,
                    'open_time' => '09:00:00',
                    'close_time' => '18:00:00',
                    'is_closed' => false,
                ]);
            }

            // Samedi
            BusinessHour::create([
                'space_id' => $space->id,
                'day_of_week' => 6,
                'open_time' => '10:00:00',
                'close_time' => '16:00:00',
                'is_closed' => false,
            ]);

            // Dimanche fermé
            BusinessHour::create([
                'space_id' => $space->id,
                'day_of_week' => 0,
                'open_time' => null,
                'close_time' => null,
                'is_closed' => true,
            ]);
        }
    }
}
