<div>
    <!-- HEADER -->
    <x-header title="Hello" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Search" responsive icon="o-funnel" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-button label="Add Item" type="button" wire:click="addItem" class="btn-primary" />

    <x-form wire:submit.prevent="requestItems" class="space-y-10">
        <div class="flex flex-wrap gap-5">
            @foreach ($items as $index => $item)
                <x-card style="max-width: 400px; margin-top: 20px;">
                    <div class="space-y-5">
                        <x-input label="Item Name" wire:model="items.{{ $index }}.name"
                            error-field="items.{{ $index }}.name" />

                        <x-input type="number" label="Quantity" wire:model="items.{{ $index }}.qty"
                            error-field="items.{{ $index }}.qty" />

                        @php
                            $units = App\Models\units::all()
                                ->map(function ($unit) {
                                    return [
                                        'id' => $unit->unit_id,
                                        'name' => "$unit->unit ($unit->unit_abbr)",
                                    ];
                                })
                                ->toArray();

                            $priorities = [
                                ['id' => 'Emergency', 'name' => 'Emergency'],
                                ['id' => 'Urgent', 'name' => 'Urgent'],
                                ['id' => 'Normal', 'name' => 'Normal'],
                                ['id' => 'Programmed', 'name' => 'Programmed'],
                            ];
                        @endphp

                        <x-select label="Unit" icon="o-user" :options="$units"
                            wire:model="items.{{ $index }}.unit" placeholder="Select unit"
                            error-field="items.{{ $index }}.unit" />

                        <x-select label="Priority" icon="o-user" :options="$priorities"
                            wire:model="items.{{ $index }}.priority" placeholder="Select priority"
                            error-field="items.{{ $index }}.priority" />

                        <x-file wire:model="items.{{ $index }}.attachment" label="Attachment"
                            hint="Only PDFs and Images (JPEG, JPG, PNG) are allowed."
                            accept="application/pdf, image/jpeg, image/jpg, image/png"
                            error-field="items.{{ $index }}.attachment" />
                        <x-progress class="progress-primary h-0.5" indeterminate wire:loading
                            wire:target="items.{{ $index }}.attachment" />

                        <x-textarea label="Note" wire:model="items.{{ $index }}.note"
                            placeholder="Item note ..." hint="Max 1000 chars" rows="5" inline
                            error-field="items.{{ $index }}.note" />

                        <x-input label="Requestor" wire:model="items.{{ $index }}.requestor"
                            error-field="items.{{ $index }}.requestor" />

                        <x-slot:actions>
                            @if (count($items) > 1)
                                <x-button label="Remove Item" type="button"
                                    wire:click="removeItem({{ $index }})" class="btn-danger" />
                            @endif
                        </x-slot:actions>
                    </div>

                </x-card>
            @endforeach
            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Submit" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </div>
    </x-form>
</div>
