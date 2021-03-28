<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            
            <!-- This example requires Tailwind CSS v2.0+ -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">

                <div class="flex justify-between">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Allocation
                        </h3>
                    </div>
                    @can ('manage-dispatch')
                    <div class="px-6 py-3">
                        <x-jet-button wire:click="createModal">
                            {{ __('Add New Waybill') }}
                        </x-jet-button>
                    </div>
                    @endcan
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $allocation->allocated_at }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Product
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $allocation->product->name }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Quantity
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $allocation->quantity }}
                            </dd>
                        </div>
                    </dl>    
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
                            Waybill #
                        </th>
                        
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($waybills as $waybill)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ str_pad($waybill->id,6,'0',STR_PAD_LEFT) }}
                        </td>
                      
                      
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($waybill->rquantity)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Received
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                            Dispatched
                            </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="#" class="text-yellow-400 hover:text-yellow-600" wire:click="viewModal({{ $waybill->id }})">View</a>
                            @can ('manage-receive') 
                            @if (! $waybill->rquantity)
                            <a href="#" class="text-green-600 hover:text-green-900" wire:click="receiveModal({{ $waybill->id }})">Receive</a>
                            @endif
                            @endcan
                            @canany (['manage-dispatch', 'manage-users'])
                            <a href="{{ route('waybill', [$waybill->id]) }}" class="text-green-600 hover:text-green-900">Print</a>
                            @endcan
                            @can ('manage-dispatch')
                            <a href="#" class="text-indigo-600 hover:text-indigo-900" wire:click="editModal({{ $waybill->id }})">Edit</a>
                            @endcan
                            @can ('manage-receive')
                            @if ($waybill->rquantity)
                            <a href="#" class="text-indigo-600 hover:text-indigo-900" wire:click="reditModal({{ $waybill->id }})">Edit</a>
                            @endif 
                            @endcan
                            @can ('manage-dispatch')
                            <a href="#" class="text-red-600 hover:text-red-900" wire:click="deleteConfirm({{ $waybill->id }})">Delete</a>
                            @endcan
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap">No record found.</td>
                        </tr>
                        @endforelse 
                    </tbody>
                    </table>
                    <div class="px-3 py-3">{{$waybills->links()}}</div>
                </div>
                </div>
            </div>
            </div>

            <x-jet-dialog-modal wire:model="viewModalVisibility">

                <x-slot name="title">
               
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Waybill
                        </h3>
                    </div>

                </x-slot>

                <x-slot name="content">
                                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Applicant Information
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Personal details and application.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Full name
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Margot Foster
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Application for
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Backend Developer
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Email address
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            margotfoster@example.com
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Salary expectation
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            $120,000
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            About
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            Fugiat ipsum ipsum deserunt culpa aute sint do nostrud anim incididunt cillum culpa consequat. Excepteur qui ipsum aliquip consequat sint. Sit id mollit nulla mollit nostrud in ea officia proident. Irure nostrud pariatur mollit ad adipisicing reprehenderit deserunt qui eu.
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                            Attachments
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <!-- Heroicon name: solid/paper-clip -->
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 w-0 truncate">
                                    resume_back_end_developer.pdf
                                    </span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Download
                                    </a>
                                </div>
                                </li>
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                <div class="w-0 flex-1 flex items-center">
                                    <!-- Heroicon name: solid/paper-clip -->
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-2 flex-1 w-0 truncate">
                                    coverletter_back_end_developer.pdf
                                    </span>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Download
                                    </a>
                                </div>
                                </li>
                            </ul>
                            </dd>
                        </div>
                        </dl>
                    </div>
                    </div>

            </x-slot>

            <x-slot name="footer">
                <x-jet-button wire:click="$toggle('viewModalVisibility')" wire:loading.attr="disabled">
                    {{ __('Close') }}
                </x-jet-button>
            </x-slot>

            </x-jet-dialog-modal>

            <x-jet-dialog-modal wire:model="modalVisibility">
                
                <x-slot name="title">
                    {{ __('Add New Waybill') }}
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <x-jet-label for="dispatched_at" value="{{ __('Date') }}" />
                        <x-jet-input id="dispatched_at" class="block mt-1 w-full" type="date" wire:model.debounce.800ms="dispatched_at" />
                        @error('dispatched_at') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="dquantity" value="{{ __('Quantity') }}" />
                        <x-jet-input id="dquantity" class="block mt-1 w-full" type="number" wire:model.debounce.800ms="dquantity" />
                        @error('dquantity') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="dbags" value="{{ __('Number of Bags') }}" />
                        <x-jet-input id="dbags" class="block mt-1 w-full" type="number" wire:model.debounce.800ms="dbags" />
                        @error('dbags') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="driver" value="{{ __('Driver') }}" />
                        <x-jet-input id="driver" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="driver" />
                        @error('driver') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="dphone" value="{{ __('Phone') }}" />
                        <x-jet-input id="dphone" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="dphone" />
                        @error('dphone') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="truck" value="{{ __('Truck number') }}" />
                        <x-jet-input id="truck" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="truck" />
                        @error('truck') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
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

            <x-jet-dialog-modal wire:model="receiveModalVisibility">
                
                <x-slot name="title">
                    {{ __('Receive Waybill') }}
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <x-jet-label for="received_at" value="{{ __('Date') }}" />
                        <x-jet-input id="received_at" class="block mt-1 w-full" type="date" wire:model.debounce.800ms="received_at" />
                        @error('received_at') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="rquantity" value="{{ __('Quantity') }}" />
                        <x-jet-input id="rquantity" class="block mt-1 w-full" type="number" wire:model.debounce.800ms="rquantity" />
                        @error('rquantity') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                    <div class="mt-4">
                        <x-jet-label for="rbags" value="{{ __('Number of Bags') }}" />
                        <x-jet-input id="rbags" class="block mt-1 w-full" type="number" wire:model.debounce.800ms="rbags" />
                        @error('rbags') <span class="text-xs text-red-600">{{ $message }} </span> @enderror
                    </div>

                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('receiveModalVisibility')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>

                   
                    <x-jet-button class="ml-2" wire:click="rcreate" wire:loading.attr="disabled">
                        {{ __('Save') }}
                    </x-jet-button>
                    
                </x-slot>
                
            </x-jet-dialog-modal>

        </div>
    </div>
</div>


