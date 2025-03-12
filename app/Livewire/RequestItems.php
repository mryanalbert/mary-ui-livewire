<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class RequestItems extends Component
{
    use WithFileUploads;

    public $items = [
        [
            'name' => '',
            'qty' => '',
            'unit' => '',
            'priority' => '',
            'attachment' => '',
            'note' => '',
            'requestor' => ''
        ]
    ];

    protected $rules = [
        'items.*.name' => 'required|string|max:255',
        'items.*.qty' => 'required|numeric|min:1',
        'items.*.unit' => 'required|numeric|exists:units,unit_id',
        'items.*.priority' => 'required|in:Emergency,Urgent,Normal,Programmed',
        'items.*.attachment' => 'required|file|mimes:pdf,jpeg,jpg,png|max:1000',
        'items.*.note' => 'required|max:1000',
        'items.*.requestor' => 'required|string|max:255',
    ];

    public function addItem()
    {
        $this->items[] = [
            'name' => '',
            'qty' => '',
            'unit' => '',
            'priority' => '',
            'attachment' => '',
            'note' => '',
            'requestor' => ''
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex array
    }

    public function requestItems()
    {
        $validated = $this->validate();

        // Process the request for each item
        foreach ($this->items as $item) {
            // Save the item to the database or perform necessary actions
        }

        // Clear the form after submission
        $this->items = [
            [
                'name' => '',
                'qty' => '',
                'unit' => '',
                'priority' => '',
                'attachment' => '',
                'note' => '',
                'requestor' => ''
            ]
        ];
    }

    public function render()
    {
        return view('livewire.request-items');
    }
}
