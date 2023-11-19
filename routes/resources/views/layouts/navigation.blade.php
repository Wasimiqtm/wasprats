<!-- [ navigation menu ] start -->
<nav class="pcoded-navbar menupos-fixed menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">
            <ul class="nav pcoded-inner-navbar ">
                @can('Dashboard')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>
                @endcan
                @can('Calendar Index')
                    <li class="nav-item">
                        <a href="{{ route('calendar.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                            <span class="pcoded-mtext">Calendar</span>
                        </a>
                    </li>
                @endcan
                @can('Users Index')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Users</span>
                        </a>
                    </li>
                @endcan
                @can('Companies Index')
                    <li class="nav-item">
                        <a href="{{ route('companies.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Companies</span>
                        </a>
                    </li>
                @endcan
                @canany(['Schedule Groups Index', 'Schedules Index'])
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-clock"></i></span><span class="pcoded-mtext">Schedule</span></a>
                        <ul class="pcoded-submenu">
                            @can('Schedule Groups Index')
                                <li><a href="{{ route('schedule-groups.index') }}">Schedule Groups</a></li>
                            @endcan
                            @can('Schedules Index')
                                <li><a href="{{ route('schedules.index') }}">Schedules</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @can('Services Index')
                    <li class="nav-item">
                        <a href="{{ route('services.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                            <span class="pcoded-mtext">Services</span>
                        </a>
                    </li>
                @endcan
                @can('Items Index')
                    <li class="nav-item">
                        <a href="{{ route('items.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-shopping-cart"></i></span>
                            <span class="pcoded-mtext">Items</span>
                        </a>
                    </li>
                @endcan
                @can('Customers Index')
                    <li class="nav-item">
                        <a href="{{ route('customers.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                            <span class="pcoded-mtext">Customers</span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item pcoded-menu-caption">
                    <label>Settings</label>
                </li>

                @can('Industries Index')
                    <li class="nav-item">
                        <a href="{{ route('industries.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Industries</span>
                        </a>
                    </li>
                @endcan
                @can('Taxes Index')
                    <li class="nav-item">
                        <a href="{{ route('taxes.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                            <span class="pcoded-mtext">Taxes</span>
                        </a>
                    </li>
                @endcan
                @can('Countries Index')
                    <li class="nav-item">
                        <a href="{{ route('countries.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-globe"></i></span>
                            <span class="pcoded-mtext">Countries</span>
                        </a>
                    </li>
                @endcan
                @can('Currencies Index')
                    <li class="nav-item">
                        <a href="{{ route('currencies.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                            <span class="pcoded-mtext">Currencies</span>
                        </a>
                    </li>
                @endcan
                @can('Timezone Index')
                    <li class="nav-item">
                        <a href="{{ route('timezones.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-clock"></i></span>
                            <span class="pcoded-mtext">Timezone</span>
                        </a>
                    </li>
                @endcan
                @can('Methods Index')
                    <li class="nav-item">
                        <a href="{{ route('methods.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-briefcase"></i></span>
                            <span class="pcoded-mtext">Methods</span>
                        </a>
                    </li>
                @endcan
                @can('Sources Index')
                    <li class="nav-item">
                        <a href="{{ route('sources.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                            <span class="pcoded-mtext">Sources</span>
                        </a>
                    </li>
                @endcan
                @can('Tags Index')
                    <li class="nav-item">
                        <a href="{{ route('tags.index') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-target"></i></span>
                            <span class="pcoded-mtext">Tags</span>
                        </a>
                    </li>
                @endcan
                @canany(['Role Groups Index', 'Roles Index', 'Permissions Index'])
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-box"></i></span><span class="pcoded-mtext">ACL</span></a>
                        <ul class="pcoded-submenu">
                            @can('Role Groups Index')
                                <li><a href="{{ route('role-groups.index') }}">Role Groups</a></li>
                            @endcan
                            @can('Roles Index')
                                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                            @endcan
                            @can('Permissions Index')
                                <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                    <li><a href="{{ route('system-email.index') }}"><span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                            <span class="pcoded-mtext">System Sms/Emails</span></a></li>
                    <li><a href="{{ route('custom.sms') }}"><span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                            <span class="pcoded-mtext">Custom Automated Messages</span></a></li>


                    <li class="nav-item pcoded-menu-caption">
                        <label>Reports</label>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('invoices') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">All Invoices</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customers.estimates.details') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">All Estimates</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('invoice.credits') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">All Credits</span>
                        </a>
                    </li>
                  {{--  <li class="nav-item">
                        <a href="{{ route('customer.active.jobs') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Customer Active Jobs</span>
                        </a>
                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ route('customers.report') }}" class="nav-link ">
                            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                            <span class="pcoded-mtext">Customers</span>
                        </a>
                    </li>


                @canany(['Settings Templates Index', 'Settings Tiles Index'])
                        <li class="nav-item pcoded-menu-caption">
                            <label>Custom Settings</label>
                        </li>
                    <li class="nav-item pcoded-hasmenu">
                        <a href="#" class="nav-link "><span class="pcoded-micon"><i
                                    class="feather icon-box"></i></span><span class="pcoded-mtext">Settings</span></a>
                        <ul class="pcoded-submenu">
                            @can('Settings Templates Index')
                                <li><a href="{{ route('settings.index', 'templates') }}">Templates</a></li>
                            @endcan
                            @can('Settings Tiles Index')
                                <li><a href="{{ route('settings.index', 'tiles') }}">Tiles</a></li>
                            @endcan

                        </ul>
                    </li>
                @endcanany
            </ul>
        </div>
    </div>
</nav>
<!-- [ navigation menu ] end -->



{{-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav> --}}
