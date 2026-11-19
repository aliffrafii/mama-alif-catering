{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="sticky top-0 z-40 border-b border-base-300 bg-base-100/90 backdrop-blur">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="navbar px-0 min-h-16">
            <!-- Brand -->
            <div class="navbar-start gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <x-application-logo class="h-11 w-11" />
                    <div class="leading-tight">
                        <div class="text-base sm:text-lg font-extrabold text-base-content">
                            Catering Mama Alif
                        </div>
                        <div class="text-xs opacity-70">
                            {{ auth()->user()->role === 'admin' ? 'Admin Panel' : 'Customer Area' }}
                        </div>
                    </div>
                </a>
            </div>

            <!-- Menu desktop -->
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1 gap-1">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">
                            Dashboard
                        </a>
                    </li>

                    @if (auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.customers.index') }}"
                                class="{{ request()->routeIs('admin.customers.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Customers</a>
                        </li>
                        <li><a href="{{ route('admin.products.index') }}"
                                class="{{ request()->routeIs('admin.products.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Products</a>
                        </li>
                        <li><a href="{{ route('admin.orders.index') }}"
                                class="{{ request()->routeIs('admin.orders.*') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Orders</a>
                        </li>
                    @else
                        <li><a href="{{ route('menu.nasi-box') }}"
                                class="{{ request()->routeIs('menu.nasi-box') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Nasi
                                Box</a></li>
                        <li><a href="{{ route('menu.prasmanan') }}"
                                class="{{ request()->routeIs('menu.prasmanan') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Prasmanan</a>
                        </li>
                        <li><a href="{{ route('menu.nasi-tumpeng') }}"
                                class="{{ request()->routeIs('menu.nasi-tumpeng') ? 'bg-primary text-primary-content' : 'hover:bg-base-200' }} rounded-xl">Nasi
                                Tumpeng</a></li>
                    @endif
                </ul>
            </div>

            <!-- User -->
            <div class="navbar-end gap-2">
                <span class="hidden sm:inline badge badge-outline border-base-300">
                    {{ auth()->user()->role }}
                </span>

                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                        <span class="font-semibold">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 opacity-70" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <ul tabindex="0"
                        class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 border border-base-300">
                        <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-left">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>

                <!-- Mobile menu -->
                <div class="dropdown dropdown-end lg:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-sm">Menu</div>
                    <ul tabindex="0"
                        class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-56 border border-base-300">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @if (auth()->user()->role === 'admin')
                            <li><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                            <li><a href="{{ route('admin.products.index') }}">Products</a></li>
                            <li><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                        @else
                            <li><a href="{{ route('menu.nasi-box') }}">Nasi Box</a></li>
                            <li><a href="{{ route('menu.prasmanan') }}">Prasmanan</a></li>
                            <li><a href="{{ route('menu.nasi-tumpeng') }}">Nasi Tumpeng</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
