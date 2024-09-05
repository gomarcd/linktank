<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookmark;

class Search extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }    

    public function render()
    {
        $bookmarks = Bookmark::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('url', 'like', '%' . $this->search . '%')
            ->paginate(25);

        return view('livewire.search', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
