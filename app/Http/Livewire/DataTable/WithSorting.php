<?php

namespace App\Http\Livewire\DataTable;

trait WithSorting
{
    public array $sorts = [];

    /**
     * @param $field
     * @return string|void
     */
    public function sortBy($field)
    {
        if (!isset($this->sorts[$field])) return $this->sorts[$field] = 'asc';

        if ($this->sorts[$field] === 'asc') return $this->sorts[$field] = 'desc';

        unset($this->sorts[$field]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function applySorting($query)
    {
        foreach ($this->sorts as $field => $direction) {
            $query->orderBy($field, $direction);
        }

        return $query;
    }
}
