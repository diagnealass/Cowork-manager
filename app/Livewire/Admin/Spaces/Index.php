<?php

namespace App\Livewire\Admin\Spaces;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Space;
use App\Models\Amenity;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filterType = '';
    public $filterCity = '';

    public $showCreateForm = false;
    public $showEditForm = false;
    public $editingSpaceId = null;

    // Champs du formulaire
    public $name = '';
    public $description = '';
    public $space_type = '';
    public $capacity = '';
    public $price_per_hour = '';
    public $price_per_day = '';
    public $price_per_month = '';
    public $address = '';
    public $city = '';
    public $postal_code = '';
    public $country = 'France';
    public $selectedAmenities = [];
    public $images = [];
    public $is_active = true;
    public $is_featured = false;

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'required|min:10',
        'space_type' => 'required',
        'capacity' => 'required|integer|min:1',
        'price_per_hour' => 'required|numeric|min:0',
        'price_per_day' => 'nullable|numeric|min:0',
        'price_per_month' => 'nullable|numeric|min:0',
        'address' => 'required',
        'city' => 'required',
        'postal_code' => 'required',
        'country' => 'required',
        'images.*' => 'nullable|image|max:2048',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $spaces = Space::query()
            ->with(['amenities', 'images'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('city', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType, function ($query) {
                $query->where('space_type', $this->filterType);
            })
            ->when($this->filterCity, function ($query) {
                $query->where('city', 'like', '%' . $this->filterCity . '%');
            })
            ->latest()
            ->paginate(10);

        $amenities = Amenity::all();
        $types = ['office', 'meeting_room', 'desk', 'event_space'];
        $cities = Space::select('city')->distinct()->pluck('city');

        return view('livewire.admin.spaces.index', [
            'spaces' => $spaces,
            'amenities' => $amenities,
            'types' => $types,
            'cities' => $cities,
        ])->layout('layouts.admin', [
            'title' => 'Espaces',
            'header' => 'Gestion des Espaces'
        ]);
    }

    public function openCreateForm()
    {
        $this->reset([
            'name', 'description', 'space_type', 'capacity',
            'price_per_hour', 'price_per_day', 'price_per_month',
            'address', 'city', 'postal_code', 'country',
            'selectedAmenities', 'images', 'is_active', 'is_featured'
        ]);
        $this->country = 'France';
        $this->is_active = true;
        $this->is_featured = false;
        $this->resetValidation();
        $this->showCreateForm = true;
        $this->showEditForm = false;

        // Dispatch event pour scroll
        $this->dispatch('scroll-to-form', formId: 'create-form');
    }

    public function closeCreateForm()
    {
        $this->showCreateForm = false;
        $this->reset([
            'name', 'description', 'space_type', 'capacity',
            'price_per_hour', 'price_per_day', 'price_per_month',
            'address', 'city', 'postal_code', 'country',
            'selectedAmenities', 'images'
        ]);
        $this->resetValidation();
    }

    public function create()
    {
        $this->validate();

        $space = Space::create([
            'manager_id' => auth()->id(),
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'space_type' => $this->space_type,
            'capacity' => $this->capacity,
            'price_per_hour' => $this->price_per_hour,
            'price_per_day' => $this->price_per_day,
            'price_per_month' => $this->price_per_month,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
            'currency' => 'EUR',
        ]);

        // Attacher les amenities
        if (!empty($this->selectedAmenities)) {
            $space->amenities()->attach($this->selectedAmenities);
        }

        // Upload des images
        if (!empty($this->images)) {
            foreach ($this->images as $index => $image) {
                $path = $image->store('spaces', 'public');
                $space->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index,
                ]);
            }
        }

        session()->flash('success', 'Espace créé avec succès !');
        $this->closeCreateForm();
    }

    public function edit($id)
    {
        $space = Space::with('amenities')->findOrFail($id);

        $this->editingSpaceId = $id;
        $this->name = $space->name;
        $this->description = $space->description;
        $this->space_type = $space->space_type;
        $this->capacity = $space->capacity;
        $this->price_per_hour = $space->price_per_hour;
        $this->price_per_day = $space->price_per_day;
        $this->price_per_month = $space->price_per_month;
        $this->address = $space->address;
        $this->city = $space->city;
        $this->postal_code = $space->postal_code;
        $this->country = $space->country;
        $this->is_active = $space->is_active;
        $this->is_featured = $space->is_featured;
        $this->selectedAmenities = $space->amenities->pluck('id')->toArray();

        $this->showEditForm = true;
        $this->showCreateForm = false;

        // Dispatch event pour scroll
        $this->dispatch('scroll-to-form', formId: 'edit-form');
    }

    public function closeEditForm()
    {
        $this->showEditForm = false;
        $this->reset([
            'editingSpaceId', 'name', 'description', 'space_type', 'capacity',
            'price_per_hour', 'price_per_day', 'price_per_month',
            'address', 'city', 'postal_code', 'country',
            'selectedAmenities', 'images'
        ]);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $space = Space::findOrFail($this->editingSpaceId);
        $space->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'space_type' => $this->space_type,
            'capacity' => $this->capacity,
            'price_per_hour' => $this->price_per_hour,
            'price_per_day' => $this->price_per_day,
            'price_per_month' => $this->price_per_month,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ]);

        // Synchroniser les amenities
        $space->amenities()->sync($this->selectedAmenities);

        // Upload nouvelles images si fournies
        if (!empty($this->images)) {
            $lastOrder = $space->images()->max('order') ?? -1;
            foreach ($this->images as $index => $image) {
                $path = $image->store('spaces', 'public');
                $space->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }

        session()->flash('success', 'Espace modifié avec succès !');
        $this->closeEditForm();
    }

    public function delete($id)
    {
        $space = Space::findOrFail($id);

        // Supprimer les images
        foreach ($space->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $space->delete();

        session()->flash('success', 'Espace supprimé avec succès !');
    }

    public function toggleActive($id)
    {
        $space = Space::findOrFail($id);
        $space->update(['is_active' => !$space->is_active]);

        session()->flash('success', 'Statut mis à jour !');
    }
}
