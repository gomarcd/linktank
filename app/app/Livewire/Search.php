<?php

namespace App\Livewire;

use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Computed; 
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bookmark;

class Search extends Component
{
    use WithPagination;

    public $search = '';
    public int $on_page = 10;
    public $lastDeletedId;
    public $showUndoButton = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();
        $this->lastDeletedId = $id;
        $this->showUndoButton = true;
        session()->flash('status', 'Deleted');
        Toaster::info('Bookmark deleted');
    }

    public function undoDelete()
    {
        if ($this->lastDeletedId) {
            $bookmark = Bookmark::withTrashed()->findOrFail($this->lastDeletedId);
            $bookmark->restore();

            // Clear the last deleted ID and hide the undo button
            $this->lastDeletedId = null;
            $this->showUndoButton = false;
        }
    }

    public function loadMore()
    {  
        $this->on_page += 15;  
    }

    #[Computed]
    public function getBookmarks(): Collection
    {
        return Bookmark::where(function($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('url', 'like', '%' . $this->search . '%');
        })->take($this->on_page)->get();
    }


}
