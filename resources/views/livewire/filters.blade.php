<div class="bg-gray-200 rounded shadow-inner">
    <div class="flex relative">
        <div class="w-1/2 space-y-4 p-4">
            <x-input.group inline for="filter-status" label="Status">
                <x-input.select wire:model.lazy="filters.status" id="filter-status">
                    <option value="" disabled>Select Status...</option>

                    @foreach (App\Models\Category::STATUSES as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </x-input.select>
            </x-input.group>

            {{--        <x-input.group inline for="filter-amount-min" label="Minimum Amount">--}}
            {{--            <x-input.money wire:model.lazy="filters.amount-min" id="filter-amount-min" />--}}
            {{--        </x-input.group>--}}

            {{--        <x-input.group inline for="filter-amount-max" label="Maximum Amount">--}}
            {{--            <x-input.money wire:model.lazy="filters.amount-max" id="filter-amount-max" />--}}
            {{--        </x-input.group>--}}
        </div>

        <div class="w-1/2 space-y-4 p-4">
            <x-input.group inline for="filter-create-date-min" label="Minimum Create Date">
                <x-input.date wire:model.lazy="filters.create-date-min" id="filter-create-date-min" placeholder="MM/DD/YYYY" />
            </x-input.group>

            <x-input.group inline for="filter-create-date-max" label="Maximum Create Date">
                <x-input.date wire:model.lazy="filters.create-date-max" id="filter-create-date-max" placeholder="MM/DD/YYYY" />
            </x-input.group>
        </div>
    </div>
    <div class="p-4">
        <x-button.link wire:click="resetFilters" class="flex ml-auto">Reset Filters</x-button.link>
    </div>
</div>
