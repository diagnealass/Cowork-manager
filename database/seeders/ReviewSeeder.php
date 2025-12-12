<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Booking;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $completedBookings = Booking::where('status', 'completed')->get();

        $reviews = [
            ['rating' => 5, 'title' => 'Excellent !', 'comment' => 'Espace parfait, très bien équipé et calme.'],
            ['rating' => 4, 'title' => 'Très bien', 'comment' => 'Bon espace, juste un peu cher.'],
            ['rating' => 5, 'title' => 'Parfait', 'comment' => 'Je recommande vivement, super ambiance.'],
            ['rating' => 3, 'title' => 'Correct', 'comment' => 'Bien mais WiFi un peu lent.'],
            ['rating' => 5, 'title' => 'Top !', 'comment' => 'Meilleur coworking de Paris !'],
        ];

        foreach ($completedBookings->take(5) as $index => $booking) {
            $reviewData = $reviews[$index % count($reviews)];

            Review::create([
                'user_id' => $booking->user_id,
                'space_id' => $booking->space_id,
                'booking_id' => $booking->id,
                'rating' => $reviewData['rating'],
                'title' => $reviewData['title'],
                'comment' => $reviewData['comment'],
                'is_verified' => true,
            ]);
        }
    }
}
