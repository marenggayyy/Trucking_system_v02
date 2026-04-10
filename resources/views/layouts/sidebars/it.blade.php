<aside class="w-64 h-screen bg-black text-white fixed top-0 left-0">
    <div class="p-6 text-xl font-bold border-b border-gray-700">
        IT Panel
    </div>

    <nav class="mt-4 space-y-1">

        <a href="{{ route('it.dashboard') }}"
           class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('it.dashboard') ? 'bg-gray-800' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('it.users.index') }}"
           class="block px-6 py-3 hover:bg-gray-800 {{ request()->routeIs('it.users.*') ? 'bg-gray-800' : '' }}">
           Manage Users
        </a>

        <a href="#"
           class="block px-6 py-3 hover:bg-gray-800">
           System Logs
        </a>

    </nav>
</aside>