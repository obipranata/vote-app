<div>
    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2">
            <a href="#">
                <img src="{{$idea->user->getAvatar()}}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            </div>
            <div class="mx-2 md:mx-4 w-full">
            <h4 class="text-xl font-semibold mt-0 md:mt-0">
                {{$idea->title}}
            </h4>
            <div class="text-gray-600 mt-3">
                @admin 
                    @if ($idea->spam_reports > 0)
                        <div class="text-red mb-2">Spam Reports: {{$idea->spam_reports}}</div>
                    @endif
                @endadmin
                {{$idea->description}}
            </div>
            <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                <div class="hidden md:block font-bold text-gray-900">{{$idea->user->name}}</div>
                <div class="hidden md:block">&bull;</div>
                <div>{{$idea->created_at->diffForHumans()}}</div>
                <div>&bull;</div>
                <div>{{$idea->category->name}}</div>
                <div>&bull;</div>
                <div class="text-gray-900">{{$commentsCount}} Comments</div>
                </div>
                <div x-data="{isOpen : false}" class="flex items-center space-x-2 mt-4 md:mt-0">
                    <div class="{{$idea->status->classes}} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                        {{$idea->status->name}}
                    </div>
                    @auth
                        <div class="relative"> 
                            <button 
                                @click="isOpen = !isOpen"
                                class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-1 px-3"
                            >
                                <img src="/img/dots.svg">
                            </button>
                            <ul 
                            x-cloak
                            x-show.transition.origin.top.left="isOpen" 
                            @click.away="isOpen=false" 
                            @keydown.escape.window="isOpen = false"
                            class="absolute w-48 font-semibold text-left bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                            >
                                @can('update', $idea)
                                    <li>
                                        <a 
                                            href="#" 
                                            @click.prevent="
                                                isOpen=false
                                                $dispatch('custom-show-edit-modal')
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        >
                                        Edit Idea 
                                        </a>
                                    </li>
                                @endcan
                                @can('delete', $idea)
                                    <li>
                                        <a 
                                            href="#" 
                                            @click.prevent="
                                                isOpen=false
                                                $dispatch('custom-show-delete-modal')
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        >
                                        Delete Idea
                                        </a>
                                    </li>
                                @endcan
                                    <li>
                                        <a 
                                            href="#" 
                                            @click.prevent="
                                                isOpen = false
                                                $dispatch('custom-show-mark-idea-as-spam-modal')
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        >
                                        Mark as Spam 
                                        </a>
                                    </li>
                                    <li>
                                        <a 
                                            href="#" 
                                            @click.prevent="
                                                isOpen = false
                                                $dispatch('custom-show-mark-idea-as-not-spam-modal')
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3"
                                        >
                                        Mark as Not Spam 
                                        </a>
                                    </li>
                            </ul>
                        </div>
                    @endauth
                </div>
    
                <div class="flex items-center md:hidden mt-4 md:mt-0">
                    <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                        <div class="text-sm font-bold leading-none @if($hasVoted) text-blue @endif">{{$votesCount}}</div>
                        <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                    </div>

                    @if ($hasVoted)
                        <button 
                            wire:click.prevent="vote"
                            type="submit"
                            class="w-20 text-xxs bg-blue hover:bg-blue-hover text-white font-bold rounded-xl border border-blue hover:bg-border-gray-400 transition duration-150 ease-in px-4 py-3 uppercase -mx-5"
                        >
                            Voted
                        </button>
                    @else
                        <button 
                            wire:click.prevent="vote"
                            type="submit"
                            class="w-20 text-xxs bg-gray-200 font-bold rounded-xl border border-gray-200 hover:bg-border-gray-400 transition duration-150 ease-in px-4 py-3 uppercase -mx-5"
                        >
                            Vote
                        </button>
                        
                    @endif
                </div>
    
            </div>
            </div>
        </div>
    </div>
    {{-- end idea container --}}

    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <livewire:add-comment :idea="$idea"/>
            @admin
                @if (auth()->user()->isAdmin())
                    <livewire:set-status :idea="$idea" />
                @endif
            @endadmin
        </div>
        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if($hasVoted) text-blue @endif">{{$votesCount}}</div>
                <div class="text-gray-400 text-xs leading-none">Votes</div>
            </div>
            @if ($hasVoted)
                <button 
                wire:click.prevent="vote"
                type="button"
                class=" h-11 text-xs w-32 bg-blue hover:bg-blue-hover text-white font-semibold uppercase rounded-xl border border-blue hover:border-gray-400 transition duration-150 ease-in px-6 py-3"
                >
                    <span>Voted</span>       
                </button>
            @else
                <button 
                wire:click.prevent="vote"
                type="button"
                class=" h-11 text-xs w-32 bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3"
                >
                    <span>Vote</span>       
                </button>
            @endif
        </div>
    </div>
    {{-- end buttons container --}}
</div>
    {{-- end idea and button container --}}