<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Space;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $clients = User::where('role', 'client')->get();
        $spaces = Space::all();

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed'];

        for ($i = 1; $i <= 15; $i++) {
            $client = $clients->random();
            $space = $spaces->random();

            $startDate = now()->addDays(rand(-30, 30));
            $hours = rand(4, 9);
            $endDate = $startDate->copy()->addHours($hours);

            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $status === 'completed' ? 'paid' : $paymentStatuses[array_rand($paymentStatuses)];

            $totalPrice = $space->price_per_day ?? 100;

            $booking = Booking::create([
                'user_id' => $client->id,
                'space_id' => $space->id,
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'total_hours' => $hours,
                'price_per_unit' => $totalPrice,
                'total_price' => $totalPrice,
                'status' => $status,
                'payment_status' => $paymentStatus,
            ]);

            // Créer le paiement si payé
            if ($paymentStatus === 'paid') {
                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_method' => ['stripe', 'paypal'][array_rand(['stripe', 'paypal'])],
                    'transaction_id' => 'txn_' . uniqid(),
                    'amount' => $totalPrice,
                    'currency' => 'EUR',
                    'status' => 'completed',
                ]);

                // Créer la facture
                Invoice::create([
                    'booking_id' => $booking->id,
                    'invoice_date' => $booking->created_at,
                    'due_date' => $booking->created_at->addDays(30),
                    'subtotal' => $totalPrice,
                    'tax_rate' => 20.00,
                    'tax_amount' => $totalPrice * 0.20,
                    'total_amount' => $totalPrice * 1.20,
                    'status' => 'paid',
                ]);
            }
        }
    }
}
