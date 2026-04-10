<aside class="w-64 h-screen bg-green-900 text-white fixed top-0 left-0">
    <div class="p-6 text-xl font-bold border-b border-green-700">
        Secretary Panel
    </div>

    <nav class="mt-4 space-y-1">

        <a href="{{ route('secretary.dispatch.encode') }}"
           class="block px-6 py-3 hover:bg-green-800 {{ request()->routeIs('secretary.dispatch.*') ? 'bg-green-800' : '' }}">
           Encode Dispatch
        </a>

        <a href="{{ route('secretary.payroll.encode') }}"
           class="block px-6 py-3 hover:bg-green-800 {{ request()->routeIs('secretary.payroll.*') ? 'bg-green-800' : '' }}">
           Encode Payroll
        </a>

        <a href="{{ route('secretary.records') }}"
           class="block px-6 py-3 hover:bg-green-800 {{ request()->routeIs('secretary.records') ? 'bg-green-800' : '' }}">
           Records
        </a>

    </nav>
</aside>