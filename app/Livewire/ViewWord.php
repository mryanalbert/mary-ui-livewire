<?php

namespace App\Livewire;

use App\Models\Word;
use Livewire\Component;

class ViewWord extends Component
{
    public $wordId;

    public function mount($id)
    {
        $this->wordId = $id;
    }

    public function render()
    {
        $word = Word::where('id', $this->wordId)->first();

        return view('livewire.view-word', compact('word'));
    }
}
