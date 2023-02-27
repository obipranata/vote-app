<x-app-layout>
  <div>
    <a href="{{$backUrl}}" class="flex items-center font-semibold hover:underline">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
      </svg>      
      <span class="ml-2">All ideas (or back to chosen category with filters)</span>
    </a>
  </div>

  <livewire:idea-show :idea="$idea" :votesCount="$votesCount"/>
  @can('update', $idea)
    <livewire:edit-idea :idea="$idea"/>
  @endcan
  @can('delete', $idea)
    <livewire:delete-idea :idea="$idea"/>
  @endcan

  

  <div class="comments-container relative space-y-6 md:ml-22 my-8 mt-1 pt-4">
    <div class="comment-container relative bg-white rounded-xl flex mt-4">
      <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
          <a href="#">
            <img src="https://source.unsplash.com/200x200/?face&crop=face&v=2" alt="avatar" class="w-14 h-14 rounded-xl">
          </a>
        </div>
        <div x-data="{isOpen : false}" class="md:mx-4 w-full">
          <div class="text-gray-600 line-clamp-3">
            Lorem ipsum dolor sit amet consectetur.
          </div>
          <div class="flex items-center justify-between mt-6">
            <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
              <div class="font-bold text-gray-900">Jhon Doe</div>
              <div>&bull;</div>
              <div>10 hours ago</div>
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
  </div>
  {{-- end comments container --}}
</x-app-layout>
