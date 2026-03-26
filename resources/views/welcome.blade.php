<!DOCTYPE html>
<html lang="de" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://krd.nuscheltech.de/images/lulbf.png" rel="icon">

    <title>KRD Fichtenried</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased font-sans h-full flex flex-col" onload="checkPassword()">
    <div id="passwort" style="display:none;" class="flex-grow flex flex-col">
        @include("nav")
        <main class="flex-grow">
            @yield("content")
        </main>

        <!-- MSG -->
        @if(session("msg"))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="fixed top-20 right-5 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-4 transition-opacity duration-300"
                 role="alert">
                <div>{!! session("msg") !!}</div>
                <button @click="show = false" class="text-white hover:text-gray-200 focus:outline-none">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Password Protection Script -->
    <script>
        const correctPassword = 'bf';
        const timeoutDuration = 10 * 60 * 1000; // 10 Minuten

        function checkPassword() {
            if (sessionStorage.getItem('authenticated') === 'true') {
                document.getElementById('passwort').style.display = 'flex';
                return;
            }

            // Using standard prompt/alert to match original behavior, but styled page underneath
            // We need a small delay to let styles load or it looks weird
            setTimeout(() => {
                const userPassword = prompt('Bitte gib das Passwort ein:');
                if (userPassword === correctPassword) {
                    sessionStorage.setItem('authenticated', 'true');
                    document.getElementById('passwort').style.display = 'flex';
                    setTimeout(() => {
                        sessionStorage.removeItem('authenticated');
                        alert('Deine Sitzung ist abgelaufen.');
                        location.reload();
                    }, timeoutDuration);
                } else {
                    alert('Falsches Passwort.');
                    location.reload(); // Reload to ask again cleanly
                }
            }, 100);
        }
    </script>

    <footer class="bg-slate-900 text-slate-400 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="mb-2 text-sm">Es handelt sich um ein rein fiktives Angebot!</p>
            <p class="mb-4 text-xs uppercase tracking-wider">GamingLife IS NOT APPROVED, SPONSORED, OR ENDORSED BY ROCKSTARGAMES</p>

            <div class="mt-4 flex justify-center space-x-6" x-data="{ open: false }">
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false" class="text-slate-300 hover:text-white transition-colors focus:outline-none flex items-center">
                        Profile
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="origin-bottom-center absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" x-cloak>
                        <div class="py-1">
                            @if (auth()->check())
                                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ url('/login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
