<div class="relative flex-grow focus-within:z-10">
    <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
    </div>
    <input wire:model.live.debounce.250ms="q" class="w-full h-full block p-2 pl-8 md:pl-10 text-sm rounded shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 block " placeholder="Buscar {{ $title}}" type="text">
    <div class="absolute inset-y-0 right-0 pr-2 flex items-center">
        <button wire:click="$set('q', null)" class="text-gray-200 hover:text-red-500/80 focus:outline-none">
            <svg class="h-5 w-5 stroke-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </button>
    </div>
</div>