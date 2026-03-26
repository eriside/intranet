@extends("welcome")

@section("title", "Fuhrpark")

@section("content")
    <div class="bg-slate-900 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Unser Fuhrpark</h1>
                <p class="text-xl text-slate-400 max-w-2xl mx-auto">
                    Modernste Technik für Ihre Sicherheit. Unsere Fahrzeuge sind für jeden Einsatz gerüstet.
                </p>
                <div class="w-24 h-1 bg-red-600 mx-auto mt-8 rounded"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($fuhrpark as $fahrzeug)
                    <div class="group relative bg-slate-800 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-slate-700">
                        <!-- Image Container -->
                        <div class="aspect-w-16 aspect-h-10 w-full overflow-hidden bg-slate-700">
                            <img src="{{ asset('images/'.$fahrzeug->image) }}"
                                 alt="{{$fahrzeug->name}}"
                                 class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500 ease-in-out opacity-90 group-hover:opacity-100">

                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60"></div>
                        </div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <div class="flex items-end justify-between">
                                <div>
                                    <h5 class="text-2xl font-bold text-white mb-1 drop-shadow-md">{{$fahrzeug->name}}</h5>
                                    <div class="w-12 h-1 bg-red-600 rounded transition-all duration-300 group-hover:w-full"></div>
                                </div>
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
