<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{'bg-white/90 backdrop-blur-md shadow-md': scrolled, 'bg-transparent text-white': !scrolled}"
     class="fixed top-0 w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        <img class="block h-10 w-auto" src="https://krd.nuscheltech.de/images/lulbf.png" alt="Logo">
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 items-center">
                    <a href="{{ url('/') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200"
                       :class="scrolled ? 'border-transparent text-gray-700 hover:text-red-600 hover:border-red-600' : 'border-transparent text-white hover:text-gray-200 hover:border-gray-200'">
                        Home
                    </a>
                    <a href="{{ url('/about') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200"
                       :class="scrolled ? 'border-transparent text-gray-700 hover:text-red-600 hover:border-red-600' : 'border-transparent text-white hover:text-gray-200 hover:border-gray-200'">
                        Über Uns
                    </a>
                    <a href="{{ url('/leitung') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200"
                       :class="scrolled ? 'border-transparent text-gray-700 hover:text-red-600 hover:border-red-600' : 'border-transparent text-white hover:text-gray-200 hover:border-gray-200'">
                        Unsere Leitung
                    </a>
                    <a href="{{ url('/fuhrpark') }}"
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200"
                       :class="scrolled ? 'border-transparent text-gray-700 hover:text-red-600 hover:border-red-600' : 'border-transparent text-white hover:text-gray-200 hover:border-gray-200'">
                        Fuhrpark
                    </a>
                </div>
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition-colors duration-200"
                        :class="scrolled ? 'text-gray-400 hover:text-gray-500 hover:bg-gray-100' : 'text-gray-200 hover:text-white hover:bg-white/10'">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/95 backdrop-blur-md shadow-lg rounded-b-lg">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-red-700 hover:bg-gray-50 hover:border-red-700 transition duration-150 ease-in-out">
                Home
            </a>
            <a href="{{ url('/about') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-red-700 hover:bg-gray-50 hover:border-red-700 transition duration-150 ease-in-out">
                Über Uns
            </a>
            <a href="{{ url('/leitung') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-red-700 hover:bg-gray-50 hover:border-red-700 transition duration-150 ease-in-out">
                Unsere Leitung
            </a>
            <a href="{{ url('/fuhrpark') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-red-700 hover:bg-gray-50 hover:border-red-700 transition duration-150 ease-in-out">
                Fuhrpark
            </a>
        </div>
    </div>
</nav>
