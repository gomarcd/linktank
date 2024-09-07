<?php

namespace App\Livewire;

use Livewire\Attributes\Computed; 
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookmark;

class Search extends Component
{
    use WithPagination;

    public $search = '';
    public int $on_page = 25; 

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();
    }

    public function undoDelete($id)
    {
        $bookmark = Bookmark::withTrashed()->findOrFail($id);
        $bookmark->restore();
    }

    public function loadMore()
    {  
        $this->on_page += 25;  
    }

    #[Computed]
    public function getBookmarks(): Collection
    {
        return Bookmark::withTrashed()
        ->where(function($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('url', 'like', '%' . $this->search . '%');
        })->take($this->on_page)->get();
    }


}
