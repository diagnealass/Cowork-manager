<div class="space-y-6" x-data="{ scrolling: false }">

    <!-- Script pour scroll automatique -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-form', (event) => {
                setTimeout(() => {
                    const formId = event.formId || 'create-form';
                    const element = document.getElementById(formId);
                    if (element) {
                        element.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start',
                            inline: 'nearest'
                        });
                        // Flash visuel
                        element.style.animation = 'pulse 0.5s ease-in-out';
                    }
                }, 200);
            });
        });
    </script>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-in fade-in duration-500" role="alert">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Header + Search + Filters -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-2xl p-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">

            <!-- Titre -->
            <div class="text-white">
                <h2 class="text-3xl font-black mb-1 flex items-center gap-3">
                    🏢 Gestion des Espaces
                </h2>
                <p class="text-blue-100 text-sm">Gérez tous vos espaces de coworking</p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <!-- Search -->
                <div class="relative flex-1 lg:w-80">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="🔍 Rechercher un espace..."
                        class="w-full px-4 py-3 pl-10 rounded-lg border-2 border-transparent focus:border-white focus:ring-2 focus:ring-white bg-white/90 backdrop-blur text-gray-900 placeholder-gray-500 shadow-lg transition-all"
                    >
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <!-- Create Button - ULTRA VISIBLE -->
                <button
    wire:click="openCreateForm"
    type="button"
    style="
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        box-shadow: 0 6px 18px rgba(16, 185, 129, 0.35);
        padding: 0.45rem 1rem;
        border: 2px solid #ffffff;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.90rem;
        color: white;
        cursor: pointer;
        transition: all 0.25s ease;
        width: auto;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    "
    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(16, 185, 129, 0.45)';"
    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 6px 18px rgba(16, 185, 129, 0.35)';"
>
    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
    </svg>
    <span>NOUVEL ESPACE</span>
</button>

            </div>
        </div>

        <!-- Filters Row -->
        <div class="flex flex-wrap gap-3 mt-4">
            <!-- Type Filter -->
            <select
                wire:model.live="filterType"
                class="px-4 py-2 rounded-lg bg-white/90 backdrop-blur border-0 text-gray-900 font-medium shadow-md hover:shadow-lg transition-all cursor-pointer">
                <option value="">📋 Tous les types</option>
                <option value="office">🏢 Bureau</option>
                <option value="meeting_room">👥 Salle de réunion</option>
                <option value="desk">💺 Bureau individuel</option>
                <option value="event_space">🎉 Espace événementiel</option>
            </select>

            <!-- City Filter -->
            <select
                wire:model.live="filterCity"
                class="px-4 py-2 rounded-lg bg-white/90 backdrop-blur border-0 text-gray-900 font-medium shadow-md hover:shadow-lg transition-all cursor-pointer">
                <option value="">📍 Toutes les villes</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}">{{ $city }}</option>
                @endforeach
            </select>

            <!-- Reset Filters -->
            @if($filterType || $filterCity)
                <button
                    wire:click="$set('filterType', ''); $set('filterCity', '')"
                    type="button"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium shadow-md hover:shadow-lg transition-all">
                    ✖ Réinitialiser
                </button>
            @endif
        </div>
    </div>

    <!-- Spaces Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($spaces as $space)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">

                <!-- Image -->
                <div class="relative h-48 bg-gradient-to-br from-blue-400 to-purple-500 overflow-hidden">
                    @php
                        $primaryImage = $space->images->where('is_primary', true)->first() ?? $space->images->first();
                    @endphp

                    @if($primaryImage)
                        <img
                            src="{{ asset('storage/' . $primaryImage->image_path) }}"
                            alt="{{ $space->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><svg class=\'w-20 h-20 text-white/50\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'/></svg></div>';"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <button
                            wire:click="toggleActive({{ $space->id }})"
                            type="button"
                            class="px-3 py-1 rounded-full text-xs font-bold shadow-lg backdrop-blur transition-all hover:scale-110 {{ $space->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                            {{ $space->is_active ? '✓ Actif' : '✖ Inactif' }}
                        </button>
                    </div>

                    <!-- Featured Badge -->
                    @if($space->is_featured)
                        <div class="absolute top-3 left-3 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            ⭐ Vedette
                        </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5">

                    <!-- Title -->
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">
                        {{ $space->name }}
                    </h3>

                    <!-- Type -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 rounded-full text-xs font-semibold">
                            @switch($space->space_type)
                                @case('office') 🏢 Bureau @break
                                @case('meeting_room') 👥 Salle réunion @break
                                @case('desk') 💺 Bureau individuel @break
                                @case('event_space') 🎉 Événementiel @break
                            @endswitch
                        </span>
                    </div>

                    <!-- Location & Capacity -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $space->city }}, {{ $space->country }}
                        </div>
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            {{ $space->capacity }} personnes
                        </div>
                    </div>

                    <!-- Prices -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @if($space->price_per_hour)
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 rounded-lg text-sm font-bold">
                                {{ number_format($space->price_per_hour, 0) }}€/h
                            </span>
                        @endif
                        @if($space->price_per_day)
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-300 rounded-lg text-sm font-bold">
                                {{ number_format($space->price_per_day, 0) }}€/j
                            </span>
                        @endif
                        @if($space->price_per_month)
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-300 rounded-lg text-sm font-bold">
                                {{ number_format($space->price_per_month, 0) }}€/m
                            </span>
                        @endif
                    </div>

                    <!-- Amenities -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($space->amenities->take(4) as $amenity)
                            <span class="text-lg" title="{{ $amenity->name }}">
                                {{ $amenity->icon }}
                            </span>
                        @endforeach
                        @if($space->amenities->count() > 4)
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                +{{ $space->amenities->count() - 4 }}
                            </span>
                        @endif
                    </div>

                    <!-- Actions - BOUTONS ULTRA VISIBLES -->
                    <div class="flex gap-2 pt-4 border-t-2 border-gray-200 dark:border-gray-700">
                        <button
                            wire:click="edit({{ $space->id }})"
                            type="button"
                            style="
                                flex: 1;
                                padding: 0.75rem 1rem;
                                background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
                                color: white;
                                font-weight: 700;
                                border-radius: 10px;
                                border: 2px solid #60a5fa;
                                box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
                                cursor: pointer;
                                transition: all 0.2s;
                                display: flex;
                                align-items: center;
                                justify-center;
                                gap: 0.5rem;
                            "
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.5)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.4)';">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            MODIFIER
                        </button>
                        <button
                            wire:click="delete({{ $space->id }})"
                            wire:confirm="Êtes-vous sûr de vouloir supprimer cet espace ?"
                            type="button"
                            style="
                                padding: 0.75rem 1rem;
                                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                                color: white;
                                font-weight: 700;
                                border-radius: 10px;
                                border: 2px solid #f87171;
                                box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
                                cursor: pointer;
                                transition: all 0.2s;
                            "
                            onmouseover="this.style.transform='translateY(-2px) scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.5)';"
                            onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.4)';">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Aucun espace trouvé</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">@if($search)
                            Aucun résultat pour "{{ $search }}"
                        @else
                            Commencez par créer votre premier espace
                        @endif
                    </p>

                    @if(!$search)
                        <button
                            wire:click="openCreateForm"
                            type="button"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold rounded-lg shadow-lg transition-all hover:scale-105">
                            Créer le premier espace
                        </button>
                    @endif
                    </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
@if($spaces->hasPages())
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4">
        {{ $spaces->links() }}
    </div>
@endif

<!-- CREATE FORM PANEL -->
@if($showCreateForm)
    @include('livewire.admin.spaces.partials.create-form')
@endif

<!-- EDIT FORM PANEL -->
@if($showEditForm)
    @include('livewire.admin.spaces.partials.edit-form')
@endif

