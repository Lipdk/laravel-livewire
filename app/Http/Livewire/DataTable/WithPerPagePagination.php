<?php

namespace App\Http\Livewire\DataTable;
use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    /** @var int  */
    public int $perPage = 10;

    /**
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    /**
     * @param $value
     * @return void
     */
    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function applyPagination($query)
    {
        return $query->paginate($this->perPage);
    }
}
