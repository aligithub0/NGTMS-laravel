<div class="border-b border-gray-200 bg-white">
    <div class="flex items-center h-16 px-4 sm:px-6 lg:px-8">
        <button @click="sidebarOpen = true" class="mr-4 text-gray-500 md:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <div class="flex-1 flex justify-between items-center">
            <div class="flex items-center">
                <!-- Search bar can go here -->
            </div>
            
            <div class="ml-4 flex items-center md:ml-6">
                <!-- Notifications -->
                <x-dropdown align="right" width="w-72">
                    <x-slot name="trigger">
                        <button class="p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>
                    </x-slot>
                    
                    <x-slot name="content">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification 1</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification 2</a>
                        </div>
                    </x-slot>
                </x-dropdown>
                
                <!-- Profile dropdown -->
                <x-dropdown align="right" width="w-48">
                    <x-slot name="trigger">
                        <button class="flex items-center max-w-xs text-sm rounded-full focus:outline-none">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=FFFFFF&background=14b8a6" alt="">
                            <span class="ml-2 hidden md:block text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </button>
                    </x-slot>
                    
                    <x-slot name="content">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</div>