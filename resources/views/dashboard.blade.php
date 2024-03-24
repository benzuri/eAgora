<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticketing y pagos') }}
        </h2>
        <span class="text-sm text-gray-500">Crea y gestiona inscripciones, entradas, bonos o pagos</span>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('procedures')
            </div>
        </div>
    </div>
</x-app-layout>