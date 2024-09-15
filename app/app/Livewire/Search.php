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
    public $isEditingId = null;
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

    public function addBookmark()
    {
        Bookmark::create([
            'title' => $this->title,
            'url' => $this->url,
            'description' => $this->description,
        ]);
        Toaster::success('Added: ' . e($this->url) . '.');
        return $this->redirect('/search');
    }

    public function editBookmark($id)
    {
        $this->isEditingId = $id;
        $bookmark = Bookmark::find($id);
        $this->bookmark_id = $bookmark->id;
        $this->title = $bookmark->title;
        $this->url = $bookmark->url;
        $this->description = $bookmark->description;
        
    }

    public function updateBookmark()
    {        
        $bookmark = Bookmark::find($this->bookmark_id);
        $bookmark->update([
            'title' => $this->title,
            'url' => $this->url,
            'description' => $this->description,
        ]);
        Toaster::success('Updated: ' . e($bookmark->title) . '.');
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
