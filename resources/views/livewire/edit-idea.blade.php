<div 
    x-cloak
    x-data="{isOpen:false}"
    x-show="isOpen"
    @keydown.escape.window="isOpen = false"
    @custom-show-edit-modal.window="
        isOpen = true
        $nextTick(() => $refs.title.focus())
    "
    class="fixed z-10 inset-0 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    x-init = "
    window.livewire.on('ideaWasUpdated', () => {
        isOpen = false;
    })
"
>
    <div class="flex items-end justify-center min-h-screen">
        <div 
            x-show="isOpen"
            x-transition.opacity
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
            aria-hidden="true"
        >
        </div>

        <div 
            x-show ="isOpen"
            x-transition.origin.bottom.duration.400ms
            class="modal bg-white rounded-tl-xl rounded-tr-xl overflow-hidden transform transition-all py-4 sm:max-w-lg sm:w-full"
        >
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button 
                    @click="isOpen = false"
                    class="text-gray-400 hover:text-gray-500"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-center text-lg font-medium text-gray-900">Edit Idea</h3>
                <p class="text-xs text-center leading-5 text-gray-500 px-6 mt-4">You have one hour to edit your idea from the time you created it.</p>
                <form wire:submit.prevent="updateIdea" action="#" method="POST" class="space-y-4 px-4 py-6">
                    <div>
                        <input wire:model.defer="title" x-ref="title" type="text" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 px-4 py-2 border-none" placeholder="Your Idea">
                        @error('title')
                            <p class="text-red text-xs mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <select wire:model.defer="category" name="category_add" id="category_add" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 px-4 py-2 border-none">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red text-xs mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div>
                        <textarea wire:model.defer="description" name="idea" id="idea" cols="30" rows="4" class="w-full bg-gray-100 rounded-xl placeholder:gray-900 text-sm px-4 py-2 border-none" placeholder="Describe your idea"></textarea>
                        @error('description')
                            <p class="text-red text-xs mt-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="flex item-center justify-between space-x-3">
                        <button 
                            type="button"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3"
                        >
                            <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" />
                            </svg>
                            <span class="ml-1">Attach</span>
                        </button>
                        <button 
                            type="submit"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3"
                        >
                            <span class="ml-1">Update</span>
                        </button>
                    </div>
                </form>
            </div>

        </div> <!-- end modal -->
    </div>
</div>