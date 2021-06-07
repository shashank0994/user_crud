<div class="py-12">
    <div class="max-w-7xl mx-auto md:px-6 lg:px-8" x-data="{showModel:false,deleteUser:false,userEncryptedId:@entangle('userId')}">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto md:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full md:px-6 lg:px-8">
                    @if($users_count > 0)
                        <div class="grid grid-cols-2">
                            <div>
                                <x-input placeholder="Search for User..." name="search" class="mb-3 px-1" wire:model="search_string" type="search" />
                            </div>
                            <div class="text-right self-center">
                                <x-link active="true" wire:click="createUser" href="javascript:void(0)">Add New</x-link>
                            </div>
                        </div>
                        <div class="shadow overflow-hidden border-b border-gray-200 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Avatar
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Experience
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($users as $user)
                                    <tr>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-2">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <img class="w-10 h-10 rounded-full" src="{{secure_asset('storage/'.$user->avatar)}}" alt="{{$user->name}}" loading="lazy">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                {{$user->name}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                                {{$user->experience}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <x-button x-on:click="userEncryptedId = '{{encrypt($user->id)}}'">
                                               <span class="flex items-center">
                                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                   <span>Remove</span>
                                               </span>
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="flex flex-col items-center">
                                                <img class="w-40 m-auto" src="{{secure_asset('assets/images/emptyList.png')}}" alt="">
                                                <div class="text-center flex flex-col items-center">
                                                    <span class="text-xl font-semibold mb-2">Oops... no matching result found</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            <div class="my-4 px-4">
                                {{$users->links()}}
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col items-center">
                            <img class="w-1/2" src="{{secure_asset('assets/images/emptyList.png')}}" alt="">
                            <div class="text-center flex flex-col items-center">
                                <x-link active="true" wire:click="createUser" href="javascript:void(0)">Add New User</x-link>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div x-cloak x-show="userEncryptedId != ''">
            <div class="fixed top-0 left-0 bg-opacity-50 w-full h-screen bg-gray-100 z-40 flex items-center justify-center">
                <div class="w-11/12 md:w-1/2 shadow-2xl bg-white rounded-lg p-4 text-gray-800">
                    <h2 class="text-xl font-semibold mb-4 text-center">Are you sure you want to delete?</h2>
                    <div class="flex space-x-8 justify-center">
                         <x-button x-on:click="userEncryptedId = ''" wire:click="DeleteUser">Delete</x-button>
                         <x-button x-on:click="userEncryptedId = ''">Cancel</x-button>
                    </div>
                </div>
            </div>
        </div>
        @if($createUserModel)
            <div class="fixed top-0 left-0 bg-opacity-50 w-full h-screen bg-gray-100 z-40 flex items-center justify-center">
                <div class="w-11/12 md:w-1/2 shadow-2xl bg-white rounded-lg p-4 text-gray-800">
                    <h2 class="text-xl font-semibold mb-4">Add New Record</h2>
                    <form wire:submit.prevent="saveUser">
                        <div class="my-3">
                            <x-label>Email</x-label>
                            <x-input type="email" name="email" class="px-1" placeholder="Enter the Email Address" wire:model.defer="email"  />
                        </div>
                        <div class="my-3">
                            <x-label>Full Name</x-label>
                            <div class="">
                                <x-input type="text" name="name" class="px-1" placeholder="Enter the name" wire:model.defer="name"  />
                            </div>
                        </div>
                        <div class="my-3">
                            <x-label>Date of Joining</x-label>
                            <div class="w-max">
                                <x-input type="date" name="joining_date" class="px-1" wire:model.defer="joining_date" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}"  />
                            </div>
                        </div>
                        <div class="my-3">
                            <x-label>Date of Leaving</x-label>
                            <div class="flex items-center space-x-4">
                                <div class="w-max">
                                    <x-input type="date" name="leaving_date" wire:model.defer="leaving_date" max="{{\Carbon\Carbon::now()->format('Y-m-d')}}" />
                                </div>
                                <div class="w-1/2">
                                    <x-label class="flex items-center space-x-2">
                                        Still Working
                                        <input class="ml-2" type="checkbox" name="still_working" wire:model.defer="still_working">
                                    </x-label>
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <x-label>Upload Image</x-label>
                            <div class="">
                                <x-input type="file" name="avatar" wire:model.defer="avatar"  />
                            </div>
                        </div>
                        <div class="flex">
                            <x-button class="mx-2" type="submit">Save</x-button>
                            <x-button type="button" wire:click="$set('createUserModel',false)">Cancel</x-button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
