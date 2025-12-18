<div class="space-y-6">

    <!-- Script pour scroll automatique -->
    <script>
        document.addEventListener('livewire:updated', function() {
            const createForm = document.getElementById('create-form');
            if (createForm) {
                setTimeout(() => {
                    createForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });
    </script>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header + Search + Button -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 relative z-10">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">

        <!-- Titre -->
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            📦 Gestion des Équipements
        </h2>

        <!-- Actions groupe -->
        <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">

            <!-- Search Bar -->
            <div class="relative w-full md:w-80">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="🔍 Rechercher..."
                    class="w-full px-4 py-2.5 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Create Button -->
            <button
                onclick="this.disabled = true; setTimeout(() => { this.disabled = false; }, 500);"
                wire:click="openCreateModal"
                @if($showCreateModal) @endif
                style="background: linear-gradient(to right, #22c55e, #16a34a); box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4); padding: 0.75rem 1.75rem; display: flex; align-items: center; gap: 0.75rem; color: white; font-weight: bold; font-size: 1rem; border: none; border-radius: 0.5rem; cursor: pointer; position: relative; z-index: 30; flex-shrink: 0;"
                class="hover:shadow-2xl active:scale-95 transition-all duration-200"
                onmouseover="this.style.boxShadow='0 15px 35px rgba(34, 197, 94, 0.6)'"
                onmouseout="this.style.boxShadow='0 10px 25px rgba(34, 197, 94, 0.4)'"
                title="Cliquez pour ajouter un nouvel équipement">
                <svg class="w-6 h-6" style="flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                </svg>
                <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.2;">
                    <span style="font-size: 0.95rem; font-weight: 600; color: white;">Nouvel Équipement</span>
                    <span style="font-size: 0.8rem; font-weight: 400; color: rgba(255, 255, 255, 0.85);">Ajouter un équipement</span>
                </div>
            </button>

        </div>
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

    <!-- Create Form Panel -->
@if($showCreateModal)
    <div id="create-form" class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-900 dark:to-gray-800 border-4 border-green-500 dark:border-green-600 rounded-xl shadow-2xl p-8 mb-6 scroll-mt-6 animate-in fade-in duration-300">
        <form wire:submit.prevent="create" class="space-y-6">
            <!-- Header -->
            <div class="mb-8 pb-6 border-b-2 border-green-200 dark:border-green-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-black text-green-700 dark:text-green-400">
                            ✨ Créer un nouvel équipement
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Remplissez les champs ci-dessous pour ajouter un équipement</p>
                    </div>
                    <button
                        type="button"
                        wire:click="closeCreateModal"
                        class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors p-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="space-y-6">

                    <!-- Name -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            🏷️ Nom de l'équipement *
                        </label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-3 border-2 border-green-400 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base"
                            placeholder="ex: WiFi, Projecteur, Climatisation..."
                            autofocus
                        >
                        @error('name')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            😊 Icône (emoji)
                        </label>
                        <input
                            type="text"
                            wire:model="icon"
                            class="w-full px-4 py-3 border-2 border-green-400 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base"
                            placeholder="📶 🖥️ ❄️"
                        >
                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-3 bg-yellow-100 dark:bg-yellow-900 p-2 rounded">
                            💡 <strong>Suggestions:</strong> 📶 WiFi | 🖥️ Écran | 🎤 Micro | ❄️ Clim | ☕ Café
                        </p>
                        @error('icon')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            📂 Catégorie
                        </label>
                        <select
                            wire:model="category"
                            class="w-full px-4 py-3 border-2 border-green-400 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base">
                            <option value="">-- Sélectionner une catégorie --</option>
                            <option value="connectivity">🌐 Connectivité</option>
                            <option value="comfort">🛋️ Confort</option>
                            <option value="equipment">🖥️ Équipement</option>
                            <option value="services">☕ Services</option>
                        </select>
                        @error('category')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
            </div>

            <!-- Footer -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 mt-8 pt-6 border-t-2 border-green-300 dark:border-green-700 relative z-10">
                <button
                    type="button"
                    wire:click="closeCreateModal"
                    class="px-6 py-3 border-2 border-red-400 dark:border-red-600 rounded-lg text-red-600 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-gray-700 font-bold transition-colors text-base flex items-center justify-center gap-2 relative z-20">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span>Annuler</span>
                </button>

                <button
                    type="submit"
                    style="position: relative; z-index: 30; background: linear-gradient(to right, #22c55e, #16a34a); color: white;"
                    class="px-7 py-3 hover:from-green-600 hover:to-green-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl text-base flex items-center justify-center gap-2 border-0"
                    onmouseover="this.style.boxShadow='0 20px 40px rgba(34, 197, 94, 0.5)'"
                    onmouseout="this.style.boxShadow='0 10px 25px rgba(34, 197, 94, 0.3)'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Ajouter l'équipement</span>
                </button>
            </div>

            </form>
        </div>
    </div>
@endif
   <!-- Edit Form Panel -->
@if($showEditModal)
    <div id="edit-form" class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-gray-900 dark:to-gray-800 border-4 border-orange-500 dark:border-orange-600 rounded-xl shadow-2xl p-8 mb-6 scroll-mt-6 animate-in fade-in duration-300">
        <form wire:submit.prevent="update" class="space-y-6">
            <!-- Header -->
            <div class="mb-8 pb-6 border-b-2 border-orange-200 dark:border-orange-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-black text-orange-700 dark:text-orange-400">
                            ✏️ Modifier l'équipement
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Modifiez les informations ci-dessous</p>
                    </div>
                    <button
                        type="button"
                        wire:click="closeEditModal"
                        class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors p-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="space-y-6">
                    <!-- Name -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            🏷️ Nom de l'équipement *
                        </label>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base"
                        >
                        @error('name')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            😊 Icône (emoji)
                        </label>
                        <input
                            type="text"
                            wire:model="icon"
                            class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base"
                        >
                        @error('icon')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg">
                        <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                            📂 Catégorie
                        </label>
                        <select
                            wire:model="category"
                            class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-600 dark:bg-gray-700 dark:text-white bg-white text-gray-900 text-base">
                            <option value="">-- Sélectionner une catégorie --</option>
                            <option value="connectivity">🌐 Connectivité</option>
                            <option value="comfort">🛋️ Confort</option>
                            <option value="equipment">🖥️ Équipement</option>
                            <option value="services">☕ Services</option>
                        </select>
                        @error('category')
                            <span class="text-red-500 text-sm mt-2 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
            </div>

            <!-- Footer -->
            <div class="flex flex-col-reverse sm:flex-row justify-end gap-4 mt-8 pt-6 border-t-2 border-orange-300 dark:border-orange-700 relative z-10">
                <button
                    type="button"
                    wire:click="closeEditModal"
                    class="px-6 py-3 border-2 border-red-400 dark:border-red-600 rounded-lg text-red-600 dark:text-red-400 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-gray-700 font-bold transition-colors text-base flex items-center justify-center gap-2 relative z-20">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span>Annuler</span>
                </button>

                <button
                    type="submit"
                    style="position: relative; z-index: 30; background: linear-gradient(to right, #f97316, #ea580c); color: white;"
                    class="px-7 py-3 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-lg shadow-lg transition-all duration-200 hover:shadow-xl text-base flex items-center justify-center gap-2 border-0"
                    onmouseover="this.style.boxShadow='0 20px 40px rgba(249, 115, 22, 0.5)'"
                    onmouseout="this.style.boxShadow='0 10px 25px rgba(249, 115, 22, 0.3)'">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                    </svg>
                    <span>Mettre à jour</span>
                </button>
            </div>

            </form>
        </div>
    </div>
@endif
