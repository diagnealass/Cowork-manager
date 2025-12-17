<div class="space-y-6">

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Utilisateurs</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $stats['total_users'] }}
                    </p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        {{ $stats['active_users'] }} actifs
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Spaces -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Espaces</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $stats['total_spaces'] }}
                    </p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                        {{ $stats['active_spaces'] }} disponibles
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Réservations</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        {{ $stats['total_bookings'] }}
                    </p>
                    <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">
                        {{ $stats['pending_bookings'] }} en attente
                    </p>
                </div>
                <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Revenus</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                        €{{ number_format($stats['total_revenue'], 0, ',', ' ') }}
                    </p>
                    <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                        €{{ number_format($stats['monthly_revenue'], 0, ',', ' ') }} ce mois
                    </p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Monthly Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Revenus Mensuels {{ now()->year }}
            </h3>
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top Spaces -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Top 5 Espaces Réservés
            </h3>
            <div class="space-y-4">
                @forelse($topSpaces as $space)
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $space->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $space->city }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $space->bookings_count }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">résa</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        Aucun espace réservé
                    </p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Recent Bookings -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Activité Récente
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $booking->user->name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $booking->space->name }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900 dark:text-white">
                                €{{ number_format($booking->total_price, 2) }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $booking->start_datetime->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="ml-4">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : '' }}
                                {{ $booking->status === 'confirmed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        Aucune réservation récente
                    </p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
    const data = @json($monthlyRevenue);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Revenus (€)',
                data: months.map((m, i) => data[i + 1] || 0),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '€' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
