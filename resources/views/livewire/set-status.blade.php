<div 
    x-data="{isOpen:false}" 
    class="relative"
    x-init = "
        Livewire.on('statusWasUpdated', () => {
            isOpen = false;
        })
    "
>
    <button 
    @click="isOpen = !isOpen"
    type="button"
    class="flex items-center justify-center h-11 text-sm w-36 bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0"
    >
        <span>Set Status</span>
        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
        </svg>        
    </button>
    <div 
        x-cloak
        x-show.transition.origin.top.left="isOpen" 
        @click.away="isOpen=false" 
        @keydown.escape.window="isOpen = false"
        class="absolute z-20 w-64 md:w-76 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2"
    >
        <form wire:submit.prevent="setStatus" action="#" class="space-y-4 px-4 py-6">
            <div class="space-y-2">
                <div>
                <label class="inline-flex items-center">
                    <input wire:model="status" class="form-radio bg-gray-200 border-none text-gray-600" type="radio" checked="" name="radio-direct" value="1">
                    <span class="ml-2">Open</span>
                </label>
                </div>
                <div>
                <label class="inline-flex items-center">
                    <input wire:model="status" class="form-radio bg-gray-200 text-purple border-none" type="radio" name="radio-direct" value="2">
                    <span class="ml-2">Considering</span>
                </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" class="form-radio bg-gray-200 text-yellow border-none" type="radio" name="radio-direct" value="3">
                        <span class="ml-2">In Progress</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" class="form-radio bg-gray-200 text-green border-none" type="radio" name="radio-direct" value="4">
                        <span class="ml-2">Implemented</span>
                    </label>
                </div>
                <div>
                    <label class="inline-flex items-center">
                        <input wire:model="status" class="form-radio bg-gray-200 text-red border-none" type="radio" name="radio-direct" value="5">
                        <span class="ml-2">Closed</span>
                    </label>
                </div>
            </div>

            <textarea name="update-comment" id="update-comments" cols="30" rows="3" class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2" placeholder="Add an update comment (optional)"></textarea>

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
                    class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3 disabled:opacity-50"
                >
                    <span class="ml-1">Update</span>
                </button>
            </div>

            <div>
                <label class="font-normal inline-flex items-center">
                <input wire:model="notifyAllVoters" class="form-checkbox rounded bg-gray-200" name="notify_voters" type="checkbox">
                <span class="ml-2">Notify all voters</span>
                </label>
            </div>
        </form>
    </div>
</div>
