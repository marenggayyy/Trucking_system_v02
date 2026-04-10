<aside id="sidebar" class="sidebar sidebar-hidden md:translate-x-0">

    <!-- Profile -->
    <div class="sidebar-profile">
        <h2 class="text-center">Owner Panel</h2>
    </div>

    <!-- Home -->
    <div class="sidebar-section">Home</div>

    <a href="{{ route('owner.dashboard') }}"
        class="sidebar-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">

        <!-- Dashboard Icon -->
        <svg class="sidebar-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M3 10l9-7 9 7v11a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V10z" />
        </svg>

        Dashboard
    </a>

    <!-- Operations -->
    <div class="sidebar-section">Operations</div>

    @php
        $isOperationsOpen = request()->routeIs('owner.trips.*');
    @endphp
    <button onclick="toggleOperations()"
        class="sidebar-item w-full justify-between {{ $isOperationsOpen ? 'active' : '' }}">

        <div class="flex items-center gap-3">

            <!-- Operations Icon -->
            <svg class="sidebar-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2"
                    d="M9.75 3v2.25M14.25 3v2.25M3 9.75h18M4.5 6.75h15A1.5 1.5 0 0121 8.25v10.5A1.5 1.5 0 0119.5 20.25h-15A1.5 1.5 0 013 18.75V8.25A1.5 1.5 0 014.5 6.75z" />
            </svg>

            Operations
        </div>

        <!-- Arrow -->
        <svg id="operationsArrow" class="arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>


    </button>

    <!-- Dropdown -->
    <div id="operationsMenu" class="sidebar-dropdown {{ $isOperationsOpen ? '' : 'hidden' }}">
        <a href="{{ route('owner.trips.index') }}"
            class="sidebar-subitem {{ request()->routeIs('owner.trips.*') ? 'active' : '' }}">
            <span class="dot"> </span>
            Trips / Dispatch
        </a>
        <a href="#"
            class="sidebar-subitem {{ request()->routeIs('owner.trucks.*') ? 'active' : '' }}">
            <span class="dot"> </span>
            Trucks
        </a>
        <a href="#"
            class="sidebar-subitem {{ request()->routeIs('owner.employees.*') ? 'active' : '' }}">
            <span class="dot"> </span>
            Employees
        </a>
        <a href="#"
            class="sidebar-subitem {{ request()->routeIs('owner.destinations.*') ? 'active' : '' }}">
            <span class="dot"> </span>
            Destinations
        </a>
       
    </div>

    <!-- Finance -->
    <div class="sidebar-section">Finance</div>

    <a href="#" class="sidebar-item">

        <!-- Payroll Icon -->
        <svg class="sidebar-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2"
                d="M12 8c-1.657 0-3 .672-3 1.5S10.343 11 12 11s3 .672 3 1.5S13.657 14 12 14m0-6v12" />
        </svg>

        Payroll
    </a>

    <!-- Management -->
    <div class="sidebar-section">Management</div>

    <a href="#" class="sidebar-item">

        <!-- Users Icon -->
        <svg class="sidebar-svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M17 20h5V9H2v11h5m10 0v-2a4 4 0 00-8 0v2m8 0H7" />
        </svg>

        Users
    </a>

</aside>
