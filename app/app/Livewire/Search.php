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
    protected $listeners = ['undodelete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $bookmark = Bookmark::findOrFail($id);
        $bookmark->delete();

        Toaster::info('Bookmark deleted. <button x-on:click=\'$dispatch("undodelete", { id: ' . $bookmark->id . ' })\'><b>UNDO</b></button>');
    }

    public function undodelete($id)
    {
        $bookmark = Bookmark::withTrashed()->findOrFail($id);
        $bookmark->restore();
        
        Toaster::success('Bookmark restored!');
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
