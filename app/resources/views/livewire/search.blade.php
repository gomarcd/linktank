<div
    class="w-8/12 mx-auto pl-7"
    x-data="{ isEditingId: @entangle('isEditingId'), isAddingNewItem: false }"
    @click.away="isEditingId = null"
    >

    <!-- Search bar + add button container -->
    <div class="flex mt-8 mb-4">
        <!-- Search bar -->
        <div class="flex self-center w-11/12
                    border-4 border-transparent ring-1 ring-neutral rounded-lg
                    hover:ring-primary
                    focus-within:border-double focus-within:border-primary">
            <label for="search" class="w-full flex items-center">
                <input type="text" id="search" name="search" 
                    wire:model.live="search" 
                    class="
                        border-4 border-transparent ring-1 ring-transparent
                        focus:outline-none focus:border-4 focus:border-double focus:border-transparent
                        grow text-center bg-base-100 placeholder:text-neutral hover:placeholder-green-900 rounded-lg" 
                    placeholder="Search" 
                    x-ref="searchField" 
                    x-init="$nextTick(() => $refs.searchField.focus())"
                    @keydown.escape="$refs.searchField.blur(); $wire.set('search', '')"
                />
                <svg 
                    @click="$wire.set('search', '')"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="text-neutral size-6 hover:text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>

            </label>
        </div>

        <!-- Add button -->
        <div class="mx-auto flex items-center hover:text-success" @click="isAddingNewItem = true; $nextTick(() => $refs.addBookmarkField.focus())">
            <svg 
                xmlns="http://www.w3.org/2000/svg" 
                fill="none" 
                viewBox="0 0 24 24" 
                stroke-width="1.5" 
                stroke="currentColor" 
                class="size-8 cursor-pointer">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </div>
    </div>

    <!-- Add new item form -->
    <div x-show="isAddingNewItem" class="w-11/12 mt-4 mb-4 p-4 border-4 border-transparent ring-1 ring-neutral rounded-lg hover:ring-primary focus-within:border-double focus-within:border-primary">
            <input type="text" wire:model="url" id="addBookmark" name="addBookmark" placeholder="Enter URL"
                class="p-2 text-center grow bg-base-100 rounded-lg w-full
                border-4 border-primary ring-1 ring-transparent placeholder:text-neutral
                focus:outline-none focus:border-4 focus:border-double focus:border-primary
                hover:placeholder-green-900" x-ref="addBookmarkField" @keydown.escape="isAddingNewItem = false" />
            <div class="flex justify-end mt-2 gap-2">
                <button wire:loading.attr="disabled" wire:click="addBookmark" class="btn btn-outline btn-neutral btn-sm">Add</button>
                <button @click="isAddingNewItem = false" class="btn btn-outline btn-error btn-sm">Cancel</button>
            </div>
    </div>    

    @if($this->getBookmarks()->isEmpty())
        <div class="w-11/12 flex justify-center prose lg:prose-xl">
            <h3>There's nothin here.</h3>
        </div>
    @else
        @foreach ($this->getBookmarks as $bookmark)
            <!-- Wrapper to contain both the bookmark content and buttons outside -->
            <div x-data="{ hover: false }"
                @mouseenter="hover = true"
                @mouseleave="hover = false"
                class="flex mb-4 w-full borders"
                wire:key="bookmark-{{ $bookmark->id }}"
                >
                
                <!-- Parent div that has the border and contains the bookmark content -->
                <div class="px-4 py-2 border-4 border-transparent ring-1 ring-neutral rounded-lg w-11/12 hover:border-4 hover:border-double hover:border-primary">
                    
                    <div>
                        <!-- Render title when not editing -->
                        <div x-show="isEditingId !== {{ $bookmark->id }}">
                            <div class="font-bold">{{ $bookmark->title }}</div>
                        </div>

                        <!-- Render title when editing -->
                        <template x-if="isEditingId === {{ $bookmark->id }}">
                            <input type="text" id="title" value="{{ $bookmark->title }}" class="border-b focus:outline-none bg-base-100" x-ref="inputField" x-init="$nextTick(() => $refs.inputField.focus())" @keydown.escape="isEditingId = null">
                        </template>
                    </div>

                    <!-- Bookmark URL -->
                    <a href="{{ $bookmark->url }}" target="_blank" class="text-primary hover:underline">{{ $bookmark->url }}</a>

                    <!-- Clipboard Copy Button -->
                    <button type="button" x-data @click="$clipboard('{{ $bookmark->url }}'); Toaster.success('Copied to clipboard')" class="hover:text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                    </button>

                    <!-- Description -->
                    <p class="mt-2">{{ $bookmark->description }}</p>
                </div>

                <!-- Right side button container appears on hover -->
                <template x-if="hover">
                    <div :class="hover ? 'flex':'hidden'" class="flex flex-col justify-center gap-2 mx-auto">
                        <!-- Edit Button -->
                        <div class="cursor-pointer" @click="isEditingId = {{ $bookmark->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 hover:text-warning">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </div>
                        <!-- Delete Button -->
                        <button type="button" wire:click="delete({{ $bookmark->id }})" class="hover:text-error">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </template>
            </div>
        @endforeach
    @endif

    <!-- Infinite scroll trigger -->
    <div class="h-16" x-intersect.full="$wire.loadMore()"></div>
</div>
