<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category as Categories;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkAction;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class Category extends Component
{
    use WithFileUploads;
    use WithPagination;
    use WithCachedRows;
    use WithSorting;
    use WithBulkAction;
    use WithPerPagePagination;

    public $search = '', $name, $description, $slug, $parent_id, $image, $status, $category_id;
    public bool $showEditModal = false;

    /** @var bool Advanced Filters */
    public bool $showFilters = false;

    protected $listeners = ['delete'];
    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public array $filters = [
        'search' => '',
        'status' => '',
        'create-date-min' => null,
        'create-date-max' => null,
    ];

    // Persist in the Query String the following variables
    protected $queryString = ['sortField', 'sortDirection'];

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required|min:3',
        'slug' => 'unique:categories',
        'image' => 'nullable|file|mimes:png,jpg|max:1024', // 1MB Max
        'status' => 'boolean',
    ];

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        $this->sortField = $field;
    }

    public function create()
    {
        $this->useCachedRows();
        $this->resetFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->showEditModal = true;
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function resetFields()
    {
        $this->id = '';
        $this->name = '';
        $this->description = '';
        $this->parent_id = '';
        $this->image = '';
        $this->status = true;
    }

    // TODO: Move persisting logic to Category Model
    public function store()
    {
        if ($this->category_id) {
            $this->id = $this->category_id;
            $original = Categories::find($this->category_id)->first();

            // If it already has slug and is still the same, don't validate it
            if ($original && $original->slug == Str::slug($this->name)) {
                unset($this->rules['slug']);
            }
        }

        // Slug is idempotent, so we can regenerate it all the time
        $this->slug = Str::slug($this->name);
        $this->status = $this->status ? 1 : 0;

        try {
            $this->validate();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return;
        }

        try {
            if ($this->image) {
                $this->image->store('public/images');
                $this->image = $this->image->hashName();
            }

            Categories::updateOrCreate(['id' => $this->id], [
                'slug' => $this->slug,
                'name' => $this->name,
                'description' => $this->description,
                'parent_id' => $this->parent_id ?: 0,
                'image' => $this->image ?: null,
                'status' => $this->status,
            ]);

            session()->flash('success', $this->id ? 'Post Updated Successfully.' : 'Post Created Successfully.');
            $this->closeModal();
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while creating category!!');
        }
    }

    public function edit($id)
    {
        $this->useCachedRows();
        $category = Categories::findOrFail($id);

        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->image = $category->image;
        $this->status = $category->status;

        $this->openModal();
    }

    public function setDeleteId($id)
    {
        $this->category_id = $id;
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();
        $this->showFilters = ! $this->showFilters;
    }

    // TODO: Move persisting logic to Category Model
    public function delete()
    {
        if ($this->category_id) {
            try {
                Categories::destroy($this->category_id);
                session()->flash('success', 'Category deleted successfully.');
            } catch (\Exception $e) {
                session()->flash('error', 'Something goes wrong while deleting category!!');
            }
        }
    }

    public function removeImage()
    {
        $this->image = '';
    }

    public function getRowsQueryProperty()
    {
        $query = Categories::query()
            ->when(array_key_exists($this->filters['status'], Categories::STATUSES), fn($query, $status) => $query->where('status', (int)$this->filters['status']))
            ->when($this->filters['create-date-min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::parse($this->filters['create-date-min'])))
            ->when($this->filters['create-date-max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::parse($this->filters['create-date-max'])))
            ->when($this->filters['search'], fn($query, $search) => $query->where('name', 'like', '%'.$this->filters['search'].'%'));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
//        return view('livewire.category',  [
//            'categories' => Categories::search('name', $this->search)
//                ->orderBy($this->sortField, $this->sortDirection)
//                ->paginate(10)
//        ]);
        return view('livewire.category',  [
            'categories' => $this->rows
        ]);
    }
}
