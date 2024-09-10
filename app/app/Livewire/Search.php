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
    public $bookmark_id;
    public $title ='';
    public $url ='';
    public $description ='';
    public $showModal = false;
    protected $listeners = ['undodelete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        try {
            $bookmark = Bookmark::findOrFail($id);    
            $bookmark->delete();
            Toaster::info('<div x-on:click="toast.dispose(); $dispatch(\'undodelete\', { id: ' . $bookmark->id . ' })" style="cursor: pointer;">Deleted ' . e($bookmark->title) . '. <b>UNDO</b></div>');
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return;
        }
    }

    public function undodelete($id)
    {
        $bookmark = Bookmark::withTrashed()->findOrFail($id);
        $bookmark->restore();
        
        Toaster::success('Restored: ' . e($bookmark->title) . '.');
    }

    public function loadMore()
    {  
        $this->on_page += 15;  
    }

    public function editBookmark($id)
    {
        $bookmark = Bookmark::find($id);
        $this->bookmark_id = $bookmark->id;
        $this->title = $bookmark->title;
        $this->url = $bookmark->url;
        $this->description = $bookmark->description;
        $this->showModal = true;
    }

    public function updateBookmark()
    {        
        $bookmark = Bookmark::find($this->bookmark_id);
        if ($bookmark) {
            $bookmark->update([
                'title' => $this->title,
                'url' => $this->url,
                'description' => $this->description,
            ]);
            $this->showModal = false;
            Toaster::success('Updated: ' . e($bookmark->title) . '.');
        }
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
