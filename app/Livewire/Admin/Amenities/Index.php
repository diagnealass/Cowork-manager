<?php

namespace App\Livewire\Admin\Amenities;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Amenity;
use Illuminate\Support\Str;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingAmenityId = null;

    public $name = '';
    public $icon = '';
    public $category = '';

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'icon' => 'nullable|max:50',
        'category' => 'nullable|max:100',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $amenities = Amenity::query()
            ->withCount('spaces')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('category', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.amenities.index', [
            'amenities' => $amenities
        ])->layout('layouts.admin', [
            'title' => 'Équipements',
            'header' => 'Gestion des Équipements'
        ]);
    }

    public function openCreateModal()
    {
        $this->reset(['name', 'icon', 'category']);
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['name', 'icon', 'category']);
        $this->resetValidation();
    }

    public function create()
    {
        $this->validate();

        Amenity::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'icon' => $this->icon,
            'category' => $this->category,
        ]);

        session()->flash('success', 'Équipement créé avec succès !');
        $this->closeCreateModal();
    }

    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);

        $this->editingAmenityId = $id;
        $this->name = $amenity->name;
        $this->icon = $amenity->icon;
        $this->category = $amenity->category;

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['editingAmenityId', 'name', 'icon', 'category']);
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        $amenity = Amenity::findOrFail($this->editingAmenityId);
        $amenity->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'icon' => $this->icon,
            'category' => $this->category,
        ]);

        session()->flash('success', 'Équipement modifié avec succès !');
        $this->closeEditModal();
    }

    public function delete($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        session()->flash('success', 'Équipement supprimé avec succès !');
    }
}
