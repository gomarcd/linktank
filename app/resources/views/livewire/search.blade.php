<div>
    <br>
    <input wire:model.live="search" type="text" placeholder="Search bookmarks...">
    <br>
    {{ $bookmarks->links() }}
    <br>
    @foreach ($bookmarks as $bookmark)
        <br>
        <div>{{ $bookmark->title }}</div>
        <div>{{ $bookmark->url }}</div>
        <div>{{ $bookmark->description }}</div>
    @endforeach

    
</div>
