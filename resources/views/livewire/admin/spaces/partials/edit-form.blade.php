<div id="edit-form" class="bg-gradient-to-br from-orange-50 to-amber-100 dark:from-gray-900 dark:to-gray-800 border-4 border-orange-500 dark:border-orange-600 rounded-2xl shadow-2xl p-8 scroll-mt-6 animate-in fade-in duration-300">
    <form wire:submit.prevent="update" class="space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between pb-6 border-b-4 border-orange-300 dark:border-orange-700">
            <div>
                <h3 class="text-3xl font-black text-orange-700 dark:text-orange-400 flex items-center gap-3">
                    ✏️ Modifier l'espace
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Modifiez les informations de l'espace</p>
            </div>
            <button
                type="button"
                wire:click="closeEditForm"
                class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-all p-2 hover:scale-110">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Form Body -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Left Column -->
            <div class="space-y-5">

                <!-- Name -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        🏷️ Nom de l'espace *
                    </label>
                    <input
                        type="text"
                        wire:model="name"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 focus:border-orange-600 dark:bg-gray-700 dark:text-white transition-all"
                        placeholder="ex: Bureau Downtown Paris"
                    >
                    @error('name') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- Type -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        📋 Type d'espace *
                    </label>
                    <select
                        wire:model="space_type"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 focus:border-orange-600 dark:bg-gray-700 dark:text-white transition-all">
                        <option value="">-- Sélectionner --</option>
                        <option value="office">🏢 Bureau privé</option>
                        <option value="meeting_room">👥 Salle de réunion</option>
                        <option value="desk">💺 Bureau individuel</option>
                        <option value="event_space">🎉 Espace événementiel</option>
                    </select>
                    @error('space_type') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- Capacity -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        👥 Capacité (personnes) *
                    </label>
                    <input
                        type="number"
                        wire:model="capacity"
                        min="1"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 focus:border-orange-600 dark:bg-gray-700 dark:text-white transition-all"
                        placeholder="ex: 10"
                    >
                    @error('capacity') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        📝 Description *
                    </label>
                    <textarea
                        wire:model="description"
                        rows="5"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 focus:border-orange-600 dark:bg-gray-700 dark:text-white transition-all"
                        placeholder="Décrivez l'espace en détail..."></textarea>
                    @error('description') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

            </div>

            <!-- Right Column -->
            <div class="space-y-5">

                <!-- Prices -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-4">
                        💰 Tarifs (€)
                    </label>

                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Prix par heure *</label>
                            <input
                                type="number"
                                wire:model="price_per_hour"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2.5 border-2 border-orange-300 dark:border-orange-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white"
                                placeholder="ex: 25.00"
                            >
                            @error('price_per_hour') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Prix par jour</label>
                            <input
                                type="number"
                                wire:model="price_per_day"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2.5 border-2 border-orange-300 dark:border-orange-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white"
                                placeholder="ex: 150.00"
                            >
                            @error('price_per_day') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1 block">Prix par mois</label>
                            <input
                                type="number"
                                wire:model="price_per_month"
                                step="0.01"
                                min="0"
                                class="w-full px-4 py-2.5 border-2 border-orange-300 dark:border-orange-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white"
                                placeholder="ex: 2500.00"
                            >
                            @error('price_per_month') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        📍 Adresse complète *
                    </label>
                    <input
                        type="text"
                        wire:model="address"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-800 dark:bg-gray-700 dark:text-white transition-all"
                        placeholder="ex: 123 Rue de Rivoli"
                    >
                    @error('address') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

                <!-- City & Postal Code -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2">
                                🏙️ Ville *
                            </label>
                            <input
                                type="text"
                                wire:model="city"
                                class="w-full px-4 py-2.5 border-2 border-orange-300 dark:border-orange-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white"
                                placeholder="Paris"
                            >
                            @error('city') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 mb-2">
                                📮 Code postal *
                            </label>
                            <input
                                type="text"
                                wire:model="postal_code"
                                class="w-full px-4 py-2.5 border-2 border-orange-300 dark:border-orange-700 rounded-lg focus:ring-2 focus:ring-orange-200 dark:bg-gray-700 dark:text-white"
                                placeholder="75001"
                            >
                            @error('postal_code') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Country -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3">
                        🌍 Pays *
                    </label>
                    <input
                        type="text"
                        wire:model="country"
                        class="w-full px-4 py-3 border-2 border-orange-400 dark:border-orange-600 rounded-lg focus:ring-4 focus:ring-orange-200 dark:bg-gray-700 dark:text-white transition-all"
                        placeholder="France"
                    >
                    @error('country') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror
                </div>

            </div>

        </div>

        <!-- Full Width Sections -->
        <div class="space-y-5">

            <!-- Amenities -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-4">
                    🛠️ Équipements disponibles
                </label>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($amenities as $amenity)
                        <label class="flex items-center gap-3 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg hover:border-orange-400 dark:hover:border-orange-600 hover:bg-orange-50 dark:hover:bg-gray-700 cursor-pointer transition-all">
                            <input
                                type="checkbox"
                                wire:model="selectedAmenities"
                                value="{{ $amenity->id }}"
                                class="w-5 h-5 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                            >
                            <span class="text-2xl">{{ $amenity->icon }}</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $amenity->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Images Upload -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-4">
                    📷 Photos de l'espace
                </label>
                <div class="border-4 border-dashed border-orange-300 dark:border-orange-700 rounded-xl p-8 text-center hover:border-orange-500 dark:hover:border-orange-500 transition-all bg-orange-50 dark:bg-gray-700">
                    <input
                        type="file"
                        wire:model="images"
                        multiple
                        accept="image/*"
                        class="hidden"
                        id="images-upload"
                    >
                    <label for="images-upload" class="cursor-pointer">
                        <svg class="w-16 h-16 mx-auto text-orange-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Cliquez pour ajouter des photos
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            PNG, JPG, WEBP jusqu'à 2MB - Multiple autorisé
                        </p>
                    </label>
                </div>
                @error('images.*') <span class="text-red-600 text-sm mt-2 block font-semibold">{{ $message }}</span> @enderror

                <!-- Preview -->
                @if($images)
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        @foreach($images as $image)
                            <div class="relative group">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-24 object-cover rounded-lg shadow-md">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">✓ Prête</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Options -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-4">
                    ⚙️ Options
                </label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            class="w-6 h-6 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                        >
                        <span class="text-base font-semibold text-gray-900 dark:text-white">✅ Espace actif</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            wire:model="is_featured"
                            class="w-6 h-6 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500"
                        >
                        <span class="text-base font-semibold text-gray-900 dark:text-white">⭐ Espace vedette</span>
                    </label>
                </div>
            </div>

        </div>

       <!-- Footer Actions -->
<div class="flex flex-col-reverse sm:flex-row justify-end gap-4 pt-6 border-t-4 border-orange-300 dark:border-orange-700">

    <!-- Bouton Annuler -->
    <button
        type="button"
        wire:click="closeEditForm"
        style="
            padding: 0.875rem 1.5rem;
            border: 3px solid #3261D1;
            border-radius: 10px;
            background: linear-gradient(135deg, #3261D1 0%, #3261D1 100%);
            color: #dd0e0e;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        "
        onmouseover="this.style.background='#fef2f2'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(239, 68, 68, 0.3)';"
        onmouseout="this.style.background='white'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.2)';"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
        <span>Annuler</span>
    </button>

    <!-- Bouton Mettre à jour - ULTRA VISIBLE -->
    <button
        type="submit"
        style="
            position: relative;
            z-index: 100;
            padding: 0.875rem 2rem;
            background: linear-gradient(135deg, #3261D1 0%, #3261D1 100%);
            border: 3px solid #3261D1;
            border-radius: 10px;
            color: white;
            font-weight: 800;
            font-size: 1.05rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.5);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        "
        onmouseover="this.style.transform='translateY(-3px) scale(1.02)'; this.style.boxShadow='0 12px 35px rgba(249, 115, 22, 0.6)';"
        onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 25px rgba(249, 115, 22, 0.5)';"
    >
        <svg class="w-6 h-6" style="color: white; fill: white;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span style="color: white; font-weight: 800;">METTRE À JOUR</span>
    </button>

</div>
