<div class="comment-container relative bg-white rounded-xl flex mt-4">
    <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
        <a href="#">
            <img src="{{$comment->user->getAvatar()}}" alt="avatar" class="w-14 h-14 rounded-xl">
        </a>
        </div>
        <div x-data="{isOpen : false}" class="md:mx-4 w-full">
        <div class="text-gray-600 line-clamp-3">
            {{$comment->body}}
        </div>
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
            <div class="font-bold text-gray-900">{{$comment->user->name}}</div>
            <div>&bull;</div>
            <div>{{$comment->created_at->diffForHumans()}}</div>
            </div>
            <div class="flex items-center space-x-2">
            <div class="relative">
                <button @click="isOpen = !isOpen" class="relative bg-gray-100 hover:bg-gray-200 border transition duration-150 ease-in rounded-full h-7 py-1 px-3">
                <img src="/img/dots.svg">
                </button>
                <ul 
                x-cloak
                x-show.transition.origin.top.left="isOpen" 
                @click.away="isOpen=false" 
                @keydown.escape.window="isOpen = false"
                class="absolute w-64 font-semibold text-left bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                >
                <li>
                    <a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                    Mark as Spam 
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                    Delete Post 
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
