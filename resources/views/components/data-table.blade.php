@props(['items', 'types'=>null, 'states'=>null, 'procedures'=>null, 'title', 'sortBy', 'sortAsc', 'data', 'actions'])

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="p-4 align-middle inline-block min-w-full">
            <div class="flex flex-row gap-3 pb-6">

                <x-dashboard-crud-search title="{{$title}}" />

                @if($states)
                <div class="w-1/4">
                    <select wire:model.live="showState" id="showState" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 px-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0">Todos los estados</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if($types)
                <div class="w-1/4">
                    <select wire:model.live="showType" id="showType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 px-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0">Todas las publicaciones</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if($procedures)
                <div class="w-1/2">
                    <select wire:model.live="showProcedure" id="showProcedure" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2 px-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="0">Todas las entradas</option>
                        @foreach($procedures as $procedure)
                        <option value="{{ $procedure->id }}">{{ $procedure->title }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                @if(in_array('new', $actions))
                <button wire:click="confirmItemAdd" class="bg-emerald-600 hover:bg-grey text-emerald-100 font-bold py-1 px-3 rounded inline-flex items-center hover:bg-emerald-400 hover:text-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="text-sm">{{ __('Nueva publicación') }}</span>
                </button>
                @endif
            </div>

            <div class="overflow-hidden">
                @if ($items->count())
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($data as $key => $value)
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider @if($loop->last) w-full @endif">
                                <div class="flex items-center">
                                    <button wire:click="sortByField('{{ $key }}')" class="text-xs font-medium uppercase {{ $sortBy==$key ? 'text-gray-900' : 'text-gray-500' }}">{{ $key }}</button>
                                    <x-sort-icon sortField=" $key " :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                </div>
                            </th>
                            @endforeach
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <button wire:click="sortByField('updated_at')" class="text-xs font-medium uppercase {{ $sortBy=='updated_at' ? 'text-gray-900' : 'text-gray-500' }}">Date</button>
                                    <x-sort-icon sortField="updated_at" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                                </div>
                            </th>

                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="">Actions</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($items as $item)
                        <tr>
                            @foreach ($data as $key => $value)
                            @if($value == '[count]')
                            <td class="px-2 py-2 whitespace-nowrap">
                                <div class="text-sm truncate max-w-48 {{ $loop->first ? 'font-medium text-gray-900' : 'text-gray-500'}}">
                                    {{ count($item->$key) }}
                                </div>
                            </td>
                            @else
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="text-sm truncate max-w-48 {{ $loop->first ? 'font-medium text-gray-900' : 'text-gray-500'}}">
                                    {{ $value ? $item->$key->$value ?? $item->$key : $item->$key }}
                                </div>
                            </td>
                            @endif
                            @endforeach
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($item->updated_at ?? $item->created_at)->translatedFormat('Y m j') }}
                            </td>

                            <td class="px-4 py-2 flex flex-row justify-end gap-2">
                                @if(in_array('edit', $actions))
                                <button wire:click="confirmItemEdit( {{ $item->id }})" class="text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                        <path d="M16 5l3 3" />
                                    </svg>
                                </button>
                                @endif
                                @if(in_array('delete', $actions))
                                <button wire:click="confirmItemDeletion({{ $item->id}})" class="ms-3 text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- paginate -->
                <div class="bg-white px-4 py-1 border-t border-gray-200">
                    @if ($items->hasPages())
                    {{ $items->links() }}
                    @else
                    <p class="text-sm text-gray-700 leading-5 py-2">Showing {{ $items->count() }} results</p>
                    @endif
                </div>
                @else
                <!-- no result -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-">
                    No hay resultados
                </div>
                @endif
            </div>
        </div>
    </div>
</div>