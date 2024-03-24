<div>
    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <x-data-table :items='$items' :types='$types' :states='$states' :title="'por título'" :sortBy='$sortBy' :sortAsc='$sortAsc' :data="['title'=>'', 'type'=>'name', 'bookings'=>'[count]', 'state'=>'name', 'ended_at'=>'']" :actions="['new', 'edit', 'delete']" />
    </div>

    <x-action-message class="absolute bottom-0 right-0 mr-3" on="message">
        <div class="flex items-center p-4 mb-4 text-sm text-blue-800 rounded bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ $message }}</span>
            </div>
        </div>
    </x-action-message>

    <x-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Borrar elemento') }}
        </x-slot>

        <x-slot name="content">
            {{ __('¿Seguro que quieres borrar este elemento?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Borrar') }}
            </x-danger-button>

        </x-slot>
    </x-confirmation-modal>

    <x-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset( $this->item['id']) ? 'Editar elemento' : 'Añadir elemento' }}
        </x-slot>

        <x-slot name="content">
            <div class="">
                <x-label for="title" value="{{ __('Título') }}" />
                <x-input id="title" type="text" wire:model="item.title" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.title" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="type" value="{{ __('Tipo publicación') }}" />
                <select wire:model.defer="item.type_id" id="type" class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="0">
                        {{ __('- Seleccionar -') }}
                    </option>
                    @foreach ($types as $type)
                    <option value="{{ $type['id'] }}">
                        {{ $type['name'] }}
                    </option>
                    @endforeach
                </select>
                <x-input-error for="item.type_id" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="state" value="{{ __('Estado') }}" />
                <select wire:model.defer="item.state_id" id="state" class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="0">
                        {{ __('- Seleccionar -') }}
                    </option>
                    @foreach ($states as $state)
                    <option value="{{ $state['id'] }}">
                        {{ $state['name'] }}
                    </option>
                    @endforeach
                </select>
                <x-input-error for="item.state_id" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="is_featured" value="{{ __('Destacado') }}" />
                <select wire:model.defer="item.is_featured" id="is_featured" class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded shadow-sm mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="0">
                        {{ __('No') }}
                    </option>
                    <option value="1">
                        {{ __('Si') }}
                    </option>
                </select>
                <x-input-error for="item.is_featured" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="ended_at" value="{{ __('Caducidad') }}" />
                <x-date-picker wire:model="item.ended_at" id="ended_at" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                <x-input-error for="item.ended_at" class="mt-2" />
            </div>


        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-2 bg-blue-500 hover:bg-blue-700" wire:click="saveItem()" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @assets
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    @endassets

    @script
    <script>
        const picker = new Pikaday({
            field: document.getElementById('ended_at'),
            onSelect: date => {
                const year = date.getFullYear(),
                    month = date.getMonth() + 1,
                    day = date.getDate(),
                    formattedDate = [
                        year, month < 10 ? '0' + month : month, day < 10 ? '0' + day : day
                    ].join('-')
                document.getElementById('ended_at').value = formattedDate
            }
        })
    </script>
    @endscript
</div>