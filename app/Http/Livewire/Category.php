<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category as Categories;
use Illuminate\Support\Str;

class Category extends Component
{
    public $categories, $name, $description, $slug, $parent_id, $image, $status, $category_id;
    public $isOpen = 0;
    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required|min:3',
        'description' => 'required|min:3',
        'slug' => 'unique:categories',
    ];

    public function render()
    {
        $this->categories = Categories::all();
//        $this->categories = Categories::select('id','name','slug','description','image','status','parent_id','created_at','updated_at')->get();
        return view('livewire.category');
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetFields()
    {
        $this->id = '';
        $this->name = '';
        $this->description = '';
        $this->parent_id = '';
        $this->image = '';
        $this->status = '';
    }

    public function store()
    {
        $this->slug = Str::slug($this->name);
        $this->status = $this->status ? 1 : 0;

        try {
            $this->validate();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return;
        }

        try {
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
}
