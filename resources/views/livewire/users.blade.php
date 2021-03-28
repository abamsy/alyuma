<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Users') }}
    </h2>
</x-slot> 

<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="flex justify-between">
            <div>
            </div>
            <div class="px-6 py-6">
                <x-jet-button wire:click="createModal">
                    {{ __('Add New User') }}
                </x-jet-button>
            </div>
        </div>    
            <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Role
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                {{ $user->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                {{ $user->email }}
                                </div>
                                <div class="text-sm text-gray-500">
                                {{ $user->phone }}
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->role }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900" wire:click="editModal({{ $user->id }})">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900" wire:click="deleteConfirm({{ $user->id }})">Delete</a>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap">No record found.</td>
                        </tr>
                        @endforelse 
                    </tbody>
                    </table>
                    <div class="px-3 py-3">{{$users->links()}}</div>
                    
                </div>
                </div>
            </div>
            </div>

            <x-jet-dialog-modal wire:model="modalVisibility">
                
                <x-slot name="title">
                    {{ __('Add New User') }}
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="name" />
                        @error('name') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" wire:model.debounce.800ms="email" />
                        @error('email') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="phone" value="{{ __('Phone') }}" />
                        <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="phone" />
                        @error('phone') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="role" value="{{ __('Role:') }}" />
                        <select id="role" name="role" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model.debounce.800ms="role">
                            <option value="">--Please choose  user role--</option>
                            <option value="admin">Admin</option>
                            <option value="dispatcher">Dispatcher</option>
                            <option value="receiver">Receiver</option>
                        </select>
                        @error('role') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('modalVisibility')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                    @if($modelId)
                    <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-jet-button>
                    @else
                    <x-jet-button class="ml-2" wire:click="create" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                    @endif
                </x-slot>
                
            </x-jet-dialog-modal>

        </div>
    </div>
</div>

