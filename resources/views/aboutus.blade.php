@extends("welcome")

@section("title", "About Us")

@section("content")
    <!-- Header Image with Overlay -->
    <div class="relative w-full h-96 overflow-hidden">
        <img src="https://krd.nuscheltech.de/images/aboutushintergrund.png" alt="About Us Background" class="w-full h-full object-cover filter brightness-50">
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-5xl font-extrabold text-white tracking-tight drop-shadow-xl">Über Uns</h1>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <!-- Text Content -->
            <div class="space-y-6">
                <div class="border-l-4 border-red-600 pl-4">
                    <h2 class="text-3xl font-bold text-gray-900">Wer wir sind</h2>
                    <p class="text-lg text-red-600 font-semibold mt-1">Berufsfeuerwehr Rheinstadt</p>
                </div>

                <p class="text-gray-700 leading-relaxed text-lg">
                    Die Berufsfeuerwehr Rheinstadt ist eine moderne und engagierte Organisation, die sich rund um die Uhr für die Sicherheit und das Wohl der Bürgerinnen und Bürger von Rheinstadt einsetzt. Mit einem starken Team aus hochqualifizierten Feuerwehrleuten, innovativer Technik und einem klaren Fokus auf Professionalität stehen wir für schnellen und effektiven Einsatz – in jeder Situation.
                </p>

                <p class="text-gray-700 leading-relaxed">
                    Unsere Hauptaufgaben umfassen Brandbekämpfung, technische Hilfeleistungen, Rettungsdienste und den Schutz vor Umweltgefahren. Darüber hinaus engagieren wir uns in der Präventionsarbeit und der Ausbildung von Nachwuchskräften, um die Sicherheit in Rheinstadt nachhaltig zu stärken.
                </p>

                <p class="text-gray-700 leading-relaxed">
                    Mit Leidenschaft, Mut und Teamgeist stellen wir uns täglich neuen Herausforderungen, um unserer Mission gerecht zu werden: Leben retten, Sachwerte schützen und die Lebensqualität in Rheinstadt sichern. Wir sind mehr als nur eine Feuerwehr – wir sind ein verlässlicher Partner für unsere Stadt.
                </p>
            </div>

            <!-- Image Content -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-red-600 to-blue-600 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative">
                    <img src="https://krd.nuscheltech.de/images/aboutus.png" alt="Berufsfeuerwehr Rheinstadt Team" class="rounded-2xl shadow-2xl w-full object-cover transform transition duration-500 group-hover:scale-[1.01]">
                </div>
            </div>

        </div>
    </div>
@endsection
