<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Space;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'stats' => $this->getStats(),
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'topSpaces' => $this->getTopSpaces(),
            'recentBookings' => $this->getRecentBookings(),
        ])->layout('layouts.admin');
    }

    private function getStats()
{
    return [
        'total_users' => User::count(),
        'active_users' => User::where('is_active', true)->count(),
        'total_spaces' => Space::count(),
        'active_spaces' => Space::where('is_active', true)->count(), // ← Changé ici
        'total_bookings' => Booking::count(),
        'pending_bookings' => Booking::where('status', 'pending')->count(),
        'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
        'monthly_revenue' => Payment::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('amount'),
    ];
}

    private function getMonthlyRevenue()
    {
        return Payment::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->month => $item->total];
            });
    }

    private function getTopSpaces()
    {
        return Space::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();
    }

    private function getRecentBookings()
    {
        return Booking::with(['user', 'space'])
            ->latest()
            ->take(10)
            ->get();
    }
}
