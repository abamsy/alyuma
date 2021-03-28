<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Loading Points') }}
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
                    {{ __('Add New Loading Points') }}
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
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($points as $point)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                            <div class="ml-0">
                                <div class="text-sm font-medium text-gray-900">
                                {{ $point->name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                {{ $point->address }}
                                </div>
                                <div class="text-sm text-gray-500">
                                {{ $point->city }}
                                </div>
                                <div class="text-sm text-gray-500">
                                {{ $point->state }}
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="lallocations/{{$point->id}}" class="text-yellow-400 hover:text-yellow-600">View</a>
                            <a href="#" class="text-indigo-600 hover:text-indigo-900" wire:click="editModal({{ $point->id }})">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900" wire:click="deleteConfirm({{ $point->id }})">Delete</a>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap">No record found.</td>
                        </tr>
                        @endforelse 
                    </tbody>
                    </table>
                    <div class="px-3 py-3">{{$points->links()}}</div>
                </div>
                </div>
            </div>
            </div>

            <x-jet-dialog-modal wire:model="modalVisibility">
                
                <x-slot name="title">
                    {{ __('Add New Loading Point') }}
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="name" />
                        @error('name') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="user_id" value="{{ __('Receiver') }}" />
                        <select id="user_id" name="user_id" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model.debounce.800ms="user_id">
                            <option value="">--Please choose dispatcher--</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="address" value="{{ __('Address') }}" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="address" />
                        @error('address') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="city" value="{{ __('City/Town') }}" />
                        <x-jet-input id="city" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="city" />
                        @error('city') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="state" value="{{ __('State') }}" />
                        <select id="state" name="state" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" wire:model.debounce.800ms="state">
                            <option value="">--Please choose state--</option>
                            <option value="Abia">Abia</option>
                            <option value="Adamawa">Adamawa</option>
                            <option value="Akwa Ibom">Akwa Ibom</option>
                            <option value="Anambra">Anambra</option>
                            <option value="Bauchi">Bauchi</option>
                            <option value="Bayelsa">Bayelsa</option>
                            <option value="Benue">Benue</option>
                            <option value="Borno">Borno</option>
                            <option value="Cross River">Cross River</option>
                            <option value="Delta">Delta</option>
                            <option value="Ebonyi">Ebonyi</option>
                            <option value="Edo">Edo</option>
                            <option value="Ekiti">Ekiti</option>
                            <option value="Enugu">Enugu</option>
                            <option value="Gombe">Gombe</option>
                            <option value="Imo">Imo</option>
                            <option value="Jigawa">Jigawa</option>
                            <option value="Kaduna">Kaduna</option>
                            <option value="Kano">Kano</option>
                            <option value="Katsina">Katsina</option>
                            <option value="Kebbi">Kebbi</option>
                            <option value="Kogi">Kogi</option>
                            <option value="Kwara">Kwara</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Nasarawa">Nasarawa</option>
                            <option value="Niger">Niger</option>
                            <option value="Ogun">Ogun</option>
                            <option value="Ondo">Ondo</option>
                            <option value="Osun">Osun</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Plateau">Plateau</option>
                            <option value="Rivers">Rivers</option>
                            <option value="Sokoto">Sokoto</option>
                            <option value="Taraba">Taraba</option>
                            <option value="Yobe">Yobe</option>
                            <option value="Zamfara">Zamfara</option>
                        </select>
                        @error('state') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
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