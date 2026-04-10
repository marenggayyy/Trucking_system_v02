<aside class="w-64 h-screen bg-blue-900 text-white fixed top-0 left-0">
    <div class="p-6 text-xl font-bold border-b border-blue-700">
        Admin Panel
    </div>

    <nav class="mt-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
           class="block px-6 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('admin.dispatch.index') }}"
           class="block px-6 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.dispatch.*') ? 'bg-blue-800' : '' }}">
           Dispatch
        </a>

        <a href="{{ route('admin.trips') }}"
           class="block px-6 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.trips') ? 'bg-blue-800' : '' }}">
           Trips
        </a>

    </nav>
</aside>