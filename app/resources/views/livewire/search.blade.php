<div class="max-w-xl mx-auto">
    <!-- Search bar -->
    <div class="mb-4 pt-8">
        <label class="w-full input input-bordered flex items-center rounded-lg">
            <input type="text" wire:model.live="search" class="grow" placeholder="Search" />
        </label>
    </div>

    @if ($showUndoButton)
        @if(session('status'))
            <div x-data="{ countdown: 5, show: true }" x-init="let timer = setInterval(() => { countdown--; if (countdown <= 0) { show = false; clearInterval(timer); } }, 1000)" x-show="show" class="block items-center p-4 border border-warning rounded-lg mb-4">
                <button class="text-center w-full py-2 border " wire:click="undoDelete" @click="Toaster.success('Restored!')">
                    Undo (<span x-text="countdown"></span>)
                </button>
            </div>
        @endif
    @endif



    @foreach ($this->getBookmarks as $bookmark)
        <div class="flex justify-between items-start p-4 border border-accent rounded-lg mb-4">
            <div class="w-4/5 ml-1">
                <div class="font-bold">{{ $bookmark->title }}</div>
                <a href="{{ $bookmark->url }}" target="_blank" class="text-secondary hover:underline">{{ $bookmark->url }}</a>
                <!-- Clipboard Copy Button -->
                <button type="button" x-data @click="$clipboard('{{ $bookmark->url }}'); Toaster.success('Copied to clipboard')" class="hover:text-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                    </svg>
                </button>
                <p class="mt-2 primary">{{ $bookmark->description }}</p>                
            </div>

            <!-- Action buttons -->
            <div>


                <!-- Edit Button -->
                <button type="button" class="hover:text-yellow-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </button>

                <!-- Delete Button -->
                <button 
                    type="button" 
                    wire:click="delete({{ $bookmark->id }})" 
                    class="hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                </button>
                
            </div>
        </div>
    @endforeach
    
        <!-- Infinite scroll trigger -->
    <div class="h-16" x-intersect.full="$wire.loadMore()"></div>
</div>
