<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-600 dark:text-gray-300 leading-tight">
            {{ __('Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('component-area')
            </div>
        </div>
    </div>
</x-app-layout>
