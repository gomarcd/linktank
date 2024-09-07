<div>
    <br>
    <input wire:model.live="search" type="text" placeholder="Search bookmarks...">
    <br>
    
    <br>
    @foreach ($this->getBookmarks as $bookmark)
        <br>
        <table>
            <tr>
                <td>
        <div>{{ $bookmark->title }}</div>
        <div>{{ $bookmark->url }}</div>
        <div>{{ $bookmark->description }}</div>
                </td>
                <td>
                    @if ($bookmark->trashed())
                        <button type="button" wire:click="undoDelete({{ $bookmark->id }})">Undo</button>
                    @else
                        <button type="button" wire:click="delete({{ $bookmark->id }})">Delete</button>
                    @endif
                </td>
            </tr>
        </table>
    @endforeach

    <div x-intersect.full="$wire.loadMore()"></div>
</div>
