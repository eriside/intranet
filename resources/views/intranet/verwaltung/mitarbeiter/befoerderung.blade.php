@php use App\Models\stempeluhr;use Illuminate\Support\Carbon; @endphp
@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('Beförderung'))
        <div class="container my-5">
            <h1 class="text-center text-white mb-4">Beförderung</h1>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control text-white bg-dark border-secondary"
                       placeholder="Suchen..."
                       style="width: 300px; height: 3rem;" onkeyup="searchCards()"/>
            </div>
        </div>
        <div class="row mt-4 d-flex justify-content-center align-items-stretch">
            <form action="/intranet/verwaltung/befoerderung/new" method="get">
                @csrf
                <div class="row">
                    @foreach($mitarbeiter as $mitarbeiter)
                        @foreach($dienstgrade as $dienstgrad)
                            @if($dienstgrad->id == $mitarbeiter->dienstgrad && $mitarbeiter->aktiv && $dienstgrad->next_rang != 0)
                                <div class="col-11 col-md-4 col-lg-3 mx-2 mb-4"
                                     data-title="{{$mitarbeiter->name}} {{$mitarbeiter->dienstnummer}} {{$dienstgrad->name}}">
                                    <div class="card h-100 shadow"
                                         style="background-color: #2e3338; border: none; border-radius: 15px;">
                                        <div class="card-body text-white">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="mitarbeiter_ids[]"
                                                       value="{{$mitarbeiter->id}}" id="check_{{$mitarbeiter->id}}">
                                                <label class="form-check-label" for="check_{{$mitarbeiter->id}}">
                                                    Auswählen
                                                </label>
                                            </div>

                                            <h5 class="card-title fw-bold">{{$mitarbeiter->name}}</h5>
                                            <p class="mb-1">Dienstnummer:
                                                <strong>{{$mitarbeiter->dienstnummer}}</strong></p>
                                            <p class="mb-3">Dienstgrad: <strong>{{$dienstgrad->name}}</strong></p>
                                            <p class="mb-3">Nächster Rang: <strong>
                                                    @foreach($dienstgrade as $rang)
                                                        @if($rang->id == $dienstgrad->next_rang)
                                                            {{$rang->name}}
                                                        @endif
                                                    @endforeach
                                                </strong>
                                            </p>
                                            <p class="mb-3">Dienstzeit:
                                                <strong>
                                                    @php
                                                        $logs = stempeluhr::where('user_id', $mitarbeiter->id)->where('created_at', '>', Carbon::now()->subDays(14))->orderBy('created_at')->get();
                                                        $totalSeconds = 0;
                                                        foreach ($logs as $entry) {
                                                            if ($entry["end_time"] != null)
                                                            {
                                                                $start = strtotime($entry["start_time"]);
                                                                $end = strtotime($entry["end_time"]);
                                                                $totalSeconds += ($end - $start);
                                                            }

                                                        }
                                                        $hours = floor($totalSeconds / 3600);
                                                        $minutes = floor(($totalSeconds % 3600) / 60);
                                                    @endphp
                                                    {{$hours}} Stunden {{$minutes}} Minuten
                                                </strong>
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{url('/intranet/verwaltung/mitarbeiter/view', $mitarbeiter->id)}}"
                                                   class="btn btn-primary btn-sm rounded-pill">
                                                    Ansehen
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Ausgewählte Befördern</button>
                </div>
            </form>

        </div>
    @else
        <h1 class="text-center text-danger my-5">Keine Berechtigung</h1>
    @endif

    <script>
        function searchCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('[data-title]');

            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                card.style.display = title.includes(searchInput) ? '' : 'none';
            });
        }
    </script>

    <style>
        body {
            background-color: #1f1f1f;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .card:hover {
            transform: translateY(-2px);
            transition: 0.2s ease-in-out;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection
