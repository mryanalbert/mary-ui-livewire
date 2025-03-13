<?php

namespace App\Livewire;

use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class RequestItems extends Component
{
    use WithFileUploads;
    use Toast;

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
        'items.*.attachment' => 'file|mimes:pdf,jpeg,jpg,png|max:1000',
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

    protected $messages = [
        'items.*.name.required' => 'The item name field is required.',
        'items.*.name.string' => 'The item name must be a string.',
        'items.*.name.max' => 'The item name may not be greater than 255 characters.',

        'items.*.qty.required' => 'The quantity field is required.',
        'items.*.qty.numeric' => 'The quantity must be a number.',
        'items.*.qty.min' => 'The quantity must be at least 1.',

        'items.*.unit.required' => 'The unit field is required.',
        'items.*.unit.numeric' => 'The unit must be a number.',
        'items.*.unit.exists' => 'The selected unit is invalid.',

        'items.*.priority.required' => 'The priority field is required.',
        'items.*.priority.in' => 'The selected priority is invalid.',

        'items.*.attachment.file' => 'The attachment must be a file.',
        'items.*.attachment.mimes' => 'The attachment must be a PDF or an image (JPEG, JPG, PNG).',
        'items.*.attachment.max' => 'The attachment may not be greater than 1000 KB.',

        'items.*.note.required' => 'The note field is required.',
        'items.*.note.max' => 'The note may not be greater than 1000 characters.',

        'items.*.requestor.required' => 'The requestor field is required.',
        'items.*.requestor.string' => 'The requestor must be a string.',
        'items.*.requestor.max' => 'The requestor may not be greater than 255 characters.',
    ];

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Reindex array
    }

    public function requestItems()
    {
        $validated = $this->validate();

        try {
            DB::beginTransaction();

            foreach ($validated['items'] as $key => $item) {
                // Handle file upload for the attachment if it exists
                $attachment = null;
                if (isset($item['attachment']) && $item['attachment']) {
                    // Store the file in the 'photos' directory on the public disk
                    $attachment = $item['attachment']->store('attachments', 'public'); // Store in public/photos directory
                }

                // Save the item to the database
                Items::create([
                    'item_name' => $item['name'],
                    'item_qty' => $item['qty'],
                    'item_unit_id' => $item['unit'],
                    'item_priority' => $item['priority'],
                    'item_attachment' => $attachment,
                    'item_note' => $item['note'],
                    'item_status_id' => 'PNDH',
                    'item_created_by' => session('id'),
                    'item_requestor' => $item['requestor'],
                    'item_to_be_appr_by' => 1,
                    'item_log_by' => 1,
                ]);
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

            $this->success(
                'Item(s) requested successfully.',
                timeout: 3000,
                position: 'toast-bottom toast-end'
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            Log::error('Error submitting request items: ' . $e->getMessage());

            $this->error(
                'Something went wrong. Please try again.',
                timeout: 3000,
                position: 'toast-bottom toast-end'
            );

            dd($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.request-items');
    }
}
