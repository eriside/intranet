@extends("welcome")

@section("title", "Leitung")

@section("content")
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 tracking-tight">Leitung der Berufsfeuerwehr</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">Hier finden Sie die Ansprechpartner und Verantwortlichen unserer Wache.</p>
            </div>

            <!-- Director Section -->
            <div class="mb-16">
                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="flex-shrink-0 mx-4 text-gray-400 text-sm uppercase tracking-wider font-semibold">Direktion</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div class="flex justify-center">
                    @foreach($mitglieder as $mitglied)
                        @if($mitglied->rolle == 'Direktor der Berufsfeuerwehr')
                            <div class="w-full max-w-sm bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                                <div class="h-32 bg-gradient-to-r from-slate-800 to-slate-900"></div>
                                <div class="flex justify-center -mt-16">
                                    <img class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-md bg-white" src="{{ asset('images/'.$mitglied->image) }}" alt="{{ $mitglied->name }}">
                                </div>
                                <div class="text-center px-4 py-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $mitglied->name }}</h3>
                                    <p class="text-sm font-medium text-red-600">{{ $mitglied->rolle }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Other Roles -->
            @foreach(['Verwaltungsleitung', 'Leitender Branddirektor','Branddirektor', 'Ärztlicher Leiter Rettungsdienst', 'Verwalter'] as $rolle)
                <div class="mb-16">
                    <div class="relative flex py-5 items-center mb-8">
                        <div class="flex-grow border-t border-gray-200"></div>
                        <span class="flex-shrink-0 mx-4 text-gray-400 text-sm uppercase tracking-wider font-semibold">{{ $rolle }}</span>
                        <div class="flex-grow border-t border-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-center">
                        @foreach($mitglieder as $mitglied)
                            @if($mitglied->rolle == $rolle)
                                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 group">
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                        <img src="{{ asset('images/'.$mitglied->image) }}" alt="{{ $mitglied->name }}" class="h-64 w-full object-cover object-center group-hover:opacity-90 transition-opacity">
                                    </div>
                                    <div class="p-6 text-center">
                                        <h3 class="mt-1 text-lg font-bold text-gray-900">{{ $mitglied->name }}</h3>
                                        <p class="mt-1 text-sm text-gray-500">{{ $mitglied->rolle }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
