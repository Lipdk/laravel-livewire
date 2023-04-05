<?php

namespace App\Http\Livewire\DataTable;

trait WithCachedRows
{
    protected bool $useCache = false;

    /**
     * @param bool $useCache
     * @return $this
     */
    public function useCachedRows(bool $useCache = true)
    {
        $this->useCache = $useCache;
        return $this;
    }

    /**
     * @param $callback
     * @return \Illuminate\Contracts\Cache\Repository|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function cache($callback)
    {
        $cacheKey = $this->id;

        if ($this->useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callback();

        cache()->put($cacheKey, $result);

        return $result;
    }
}
