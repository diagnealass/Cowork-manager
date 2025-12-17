<div class="space-y-6">

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <!-- Search -->
            <div class="w-full sm:w-96">
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="🔍 Rechercher un équipement..."
                        class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    >
                    <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <!-- Create Button -->
            <button
                wire:click="openCreateModal"
                class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="font-medium">Nouvel Équipement</span>
            </button>
        </div>
    </div>

    <!-- Amenities Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Équipement
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Catégorie
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Espaces
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
    @forelse($amenities as $amenity)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">

            <!-- Équipement Column - CORRIGÉ -->
            <td class="px-6 py-4 w-1/3">
                <div class="flex items-start space-x-4">
                    @if($amenity->icon)
                        <span class="text-2xl leading-none mt-0.5">
                            {{ $amenity->icon }}
                        </span>
                    @else
                        <div class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-gray-500 dark:text-gray-400 text-sm">?</span>
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white block">
                            {{ $amenity->name }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 block mt-0.5">
                            {{ $amenity->slug }}
                        </span>
                    </div>
                </div>
            </td>

            <!-- Catégorie Column -->
            <td class="px-6 py-4 w-1/4">
                @if($amenity->category)
                    @php
                        $categoryLabels = [
                            'connectivity' => ['label' => 'Connectivité', 'icon' => '🌐'],
                            'equipment' => ['label' => 'Équipement', 'icon' => '🖥️'],
                            'comfort' => ['label' => 'Confort', 'icon' => '🛋️'],
                            'services' => ['label' => 'Services', 'icon' => '☕'],
                        ];
                        $cat = $categoryLabels[$amenity->category] ?? ['label' => $amenity->category, 'icon' => ''];
                    @endphp
                    <div class="flex items-center space-x-2">
                        <span class="text-lg">{{ $cat['icon'] }}</span>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $cat['label'] }}</span>
                    </div>
                @else
                    <span class="text-gray-400 dark:text-gray-500 text-sm">-</span>
                @endif
            </td>

            <!-- Espaces Column -->
            <td class="px-6 py-4 text-center w-1/6">
                <span class="text-sm text-gray-700 dark:text-gray-300">
                    {{ $amenity->spaces_count ?? 0 }} espaces
                </span>
            </td>

            <!-- Actions Column -->
            <td class="px-6 py-4 text-right w-1/4">
                <button
                    wire:click="edit({{ $amenity->id }})"
                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm mr-4">
                    Modifier
                </button>
                <button
                    wire:click="delete({{ $amenity->id }})"
                    wire:confirm="Êtes-vous sûr de vouloir supprimer cet équipement ?"
                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                    Supprimer
                </button>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400 text-lg mb-2">
                        @if($search)
                            Aucun équipement trouvé pour "{{ $search }}"
                        @else
                            Aucun équipement pour le moment
                        @endif
                    </p>
                    @if(!$search)
                        <button
                            wire:click="openCreateModal"
                            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Créer le premier équipement
                        </button>
                    @endif
                </div>
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($amenities->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $amenities->links() }}
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeCreateModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="create">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                Créer un équipement
                            </h3>

                            <!-- Name -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom *
                                </label>
                                <input
                                    type="text"
                                    wire:model="name"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="ex: WiFi, Projecteur..."
                                >
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Icône (emoji)
                                </label>
                                <input
                                    type="text"
                                    wire:model="icon"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="📶 🖥️ ❄️"
                                >
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    💡 Suggestions: 📶 WiFi | 🖥️ Écran | 🎤 Micro | ❄️ Clim | ☕ Café | 🅿️ Parking | 🖨️ Imprimante
                                </p>
                                @error('icon')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Catégorie
                                </label>
                                <select
                                    wire:model="category"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="connectivity">🌐 Connectivité</option>
                                    <option value="comfort">🛋️ Confort</option>
                                    <option value="equipment">🖥️ Équipement</option>
                                    <option value="services">☕ Services</option>
                                </select>
                                @error('category')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Créer
                            </button>
                            <button
                                type="button"
                                wire:click="closeCreateModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeEditModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="update">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                Modifier l'équipement
                            </h3>

                            <!-- Name -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nom *
                                </label>
                                <input
                                    type="text"
                                    wire:model="name"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                >
                                @error('name')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Icône (emoji)
                                </label>
                                <input
                                    type="text"
                                    wire:model="icon"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                >
                                @error('icon')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Catégorie
                                </label>
                                <select
                                    wire:model="category"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Sélectionner une catégorie</option>
                                    <option value="connectivity">🌐 Connectivité</option>
                                    <option value="comfort">🛋️ Confort</option>
                                    <option value="equipment">🖥️ Équipement</option>
                                    <option value="services">☕ Services</option>
                                </select>
                                @error('category')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Modal Actions -->
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Mettre à jour
                            </button>
                            <button
                                type="button"
                                wire:click="closeEditModal"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>
