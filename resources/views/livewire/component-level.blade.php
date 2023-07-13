<div class="m-4">
    <x-template-form>
        @slot('image')
            <img src="{{ Storage::url('registro.png') }}" alt="" class="rounded-t-lg h-36">
        @endslot

        @slot('form')
            <div class="col-span-1 md:col-span-12">
                <x-label>
                    {{ __('Name') }}
                </x-label>

                <x-input type="text" wire:model='name' />

                <x-input-error for="name" />
            </div>
        @endslot

        @slot('buttons')
            @if ($activity == 'create')
                <x-btn-blue wire:click='store' wire:loading.attr="disabled" wire:target="store" class="w-full md:w-1/4">
                    {{ __('Save') }}
                </x-btn-blue>
            @endif

            @if ($activity == 'edit')
                <x-btn-green wire:click='update' wire:loading.attr="disabled" wire:target="store" class="w-full md:w-1/4">
                    {{ __('Update') }}
                </x-btn-green>
            @endif
            <x-btn-red wire:click='clear' wire:loading.attr="disabled" wire:target="store" class="w-full md:w-1/4">
                {{ __('Cancel') }}
            </x-btn-red>
        @endslot
    </x-template-form>

    <x-template-list>
        @slot('search')
            <div class="col-span-1 md:col-span-12">
                <label for="default-search"
                    class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" wire:model="search"
                        class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($search != null)
                        <a wire:click='resetSearch'
                            class="text-white absolute right-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 cursor-pointer">
                            X
                        </a>
                    @endif
                </div>
            </div>
        @endslot

        @slot('options')
        @endslot

        @slot('table')
            <x-table>
                @slot('head')
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            {{ __('Name') }}
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Options</span>
                        </th>
                    </tr>
                @endslot

                @slot('body')
                    @foreach ($levels as $level)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $level->name }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <ul>
                                    <li>
                                        <a wire:click='edit({{ $level->id }})'
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                                            {{ __('Edit') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a wire:click='modalDelete({{ $level->id }})'
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline cursor-pointer">
                                            {{ __('Delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                @endslot
            </x-table>
        @endslot

        @slot('paginate')
            {{ $levels->links('vendor.livewire.custom') }}
        @endslot
    </x-template-list>

    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            <div class="flex col-span-6 sm:col-span-4 items-center">
                <x-feathericon-alert-triangle class="h-10 w-10 text-red-500 mr-2" />

                {{ __('Delete') }}
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="flex col-span-6 sm:col-span-4 items-center gap-2">
                <x-feathericon-trash class="h-20 w-20 text-red-500 mr-2" />

                <p>
                    {{ __('Once deleted, the record cannot be recovered.') }}
                </p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-btn-red wire:click="$set('deleteModal', false)" wire:loading.attr="disabled" class="w-1/3">
                {{ __('Cancel') }}
            </x-btn-red>

            <x-btn-blue class="ml-2" wire:click='delete' wire:loading.attr="disabled" class="w-1/3">
                {{ __('Accept') }}
            </x-btn-blue>
        </x-slot>
    </x-dialog-modal>
</div>
