@extends("welcome")

@section("title", "Home")

@section("content")

    <!-- Hero Section -->
    <div class="relative w-full h-screen overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="https://krd.nuscheltech.de/images/image.png" alt="Background" class="w-full h-full object-cover filter brightness-50">
        </div>

        <!-- Overlay Content -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <div class="animate-fade-in-down mb-8">
                <img src="https://krd.nuscheltech.de/images/lulbf.png" alt="Logo" class="w-32 h-32 md:w-48 md:h-48 mx-auto drop-shadow-2xl">
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4 drop-shadow-lg">
                Berufsfeuerwehr <span class="text-red-500">Rheinstadt</span>
            </h1>

            <p class="text-lg md:text-2xl font-light max-w-2xl mx-auto mb-8 text-gray-200">
                Retten &bull; Löschen &bull; Bergen &bull; Schützen
            </p>

            <div class="flex flex-col md:flex-row gap-4">
                <a href="#aktuelles" class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-full transition transform hover:scale-105 shadow-lg">
                    Aktuelles
                </a>
                <a href="{{ url('/about') }}" class="px-8 py-3 bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold rounded-full transition transform hover:scale-105 shadow-lg">
                    Mehr erfahren
                </a>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 w-full flex justify-center animate-bounce">
                <svg class="w-8 h-8 text-white opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Intro / Short About Section -->
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Willkommen bei der Wache 1</h2>
            <div class="w-24 h-1 bg-red-600 mx-auto mb-8 rounded"></div>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Die Berufsfeuerwehr Rheinstadt steht für schnellen Einsatz, Sicherheit und Schutz der Bürger.
                Mit modernster Ausrüstung und engagierten Einsatzkräften sind wir rund um die Uhr bereit.
                Unsere Mission ist es, Leben zu retten und Gefahren zu minimieren.
            </p>
        </div>
    </section>

    <!-- Aktuelles / News Section -->
    <section id="aktuelles" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-bold text-gray-900">Einsatzberichte</h3>
                <p class="mt-4 text-gray-500">Aktuelle Geschehnisse und Einsätze aus Rheinstadt</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($berichte as $bericht)
                    <div x-data="{ openModal: false }" class="flex flex-col">
                        <!-- Card -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-full border border-gray-100">
                            <div class="relative h-48 overflow-hidden group">
                                <img src="{{asset('images/'.$bericht->einsatzBild)}}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Einsatzbild">
                                <div class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold px-3 py-1 m-2 rounded shadow">
                                    {{$bericht->datum}}
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col">
                                <div class="mb-4">
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full uppercase tracking-wide font-semibold">
                                        {{$bericht->einsatzStichwort}}
                                    </span>
                                </div>
                                <h5 class="text-xl font-bold text-gray-900 mb-2 truncate">Einsatz #{{$bericht->einsatzNummer}}</h5>
                                <p class="text-gray-600 text-sm mb-4">
                                    <span class="font-medium">Uhrzeit:</span> {{$bericht->uhrzeit}} Uhr
                                </p>
                                <div class="mt-auto">
                                    <button @click="openModal = true" class="w-full py-2 px-4 bg-slate-800 hover:bg-slate-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center group">
                                        Bericht lesen
                                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div x-show="openModal"
                             style="display: none;"
                             class="fixed inset-0 z-[60] overflow-y-auto"
                             aria-labelledby="modal-title"
                             role="dialog"
                             aria-modal="true">

                            <!-- Backdrop -->
                            <div x-show="openModal"
                                 x-transition:enter="ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity"
                                 @click="openModal = false"></div>

                            <!-- Modal Panel -->
                            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                <div x-show="openModal"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-200">

                                    <!-- Header -->
                                    <div class="bg-slate-50 px-4 py-3 sm:px-6 flex justify-between items-center border-b border-gray-100">
                                        <h3 class="text-lg font-semibold leading-6 text-gray-900" id="modal-title">
                                            Einsatzbericht #{{$bericht->einsatzNummer}}
                                        </h3>
                                        <button @click="openModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                            <span class="sr-only">Schließen</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Body -->
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Stichwort</p>
                                                <p class="font-medium text-gray-900">{{$bericht->einsatzStichwort}}</p>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Zeitpunkt</p>
                                                <p class="font-medium text-gray-900">{{$bericht->datum}} - {{$bericht->uhrzeit}} Uhr</p>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <p class="text-xs text-gray-500 uppercase font-semibold">Autor</p>
                                                <p class="font-medium text-gray-900">{{$bericht->author}}</p>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-2">Lage</h4>
                                            <div class="prose text-gray-600 text-sm">
                                                @foreach($bericht->einsatzLage as $lage)
                                                    <p class="mb-1">{{$lage}}</p>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-2">Eingesetzte Fahrzeuge</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($bericht->eingesetzteFahrzeuge as $fahrzeug)
                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">{{$fahrzeug}}</span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="mt-4 rounded-lg overflow-hidden border border-gray-200">
                                            <img class="w-full object-cover max-h-64" src="{{asset('images/'.$bericht->einsatzBild)}}" alt="Einsatzbild Detail">
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button type="button" class="inline-flex w-full justify-center rounded-md bg-slate-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 sm:ml-3 sm:w-auto" @click="openModal = false">Schließen</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
