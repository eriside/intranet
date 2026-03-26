@extends("welcome")

@section("title", "Dashboard")

@section("content")
    <div class="bg-gray-50 min-h-screen py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Haupt-Dashboard</h1>
                <p class="text-lg text-gray-600">Wählen Sie einen Bereich zur Verwaltung</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Leitungsverwaltung -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 flex flex-col h-full">
                    <div class="h-2 bg-blue-500"></div>
                    <div class="p-8 flex flex-col items-center text-center flex-grow">
                        <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900 mb-3">Leitungsverwaltung</h5>
                        <p class="text-gray-500 mb-6 text-sm">Verwalten Sie die Mitglieder und Rollen der Leitungsebene.</p>
                        <div class="mt-auto">
                            <a href="{{url('/dashboard/leitung')}}" class="inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition-colors shadow-sm hover:shadow-md">
                                Zum Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fuhrpark Verwaltung -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 flex flex-col h-full">
                    <div class="h-2 bg-red-500"></div>
                    <div class="p-8 flex flex-col items-center text-center flex-grow">
                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6 text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900 mb-3">Fuhrpark Verwaltung</h5>
                        <p class="text-gray-500 mb-6 text-sm">Aktualisieren und verwalten Sie die Fahrzeuge im Fuhrpark.</p>
                        <div class="mt-auto">
                            <a href="{{url('/dashboard/fuhrpark')}}" class="inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-red-600 hover:bg-red-700 transition-colors shadow-sm hover:shadow-md">
                                Zum Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Media Team -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden border border-gray-100 flex flex-col h-full">
                    <div class="h-2 bg-green-500"></div>
                    <div class="p-8 flex flex-col items-center text-center flex-grow">
                        <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-6 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </div>
                        <h5 class="text-xl font-bold text-gray-900 mb-3">Media Team</h5>
                        <p class="text-gray-500 mb-6 text-sm">Verwalten Sie Einsatzberichte und Medieninhalte.</p>
                        <div class="mt-auto">
                            <a href="{{url('/dashboard/berichte')}}" class="inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 transition-colors shadow-sm hover:shadow-md">
                                Zum Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
