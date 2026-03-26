@extends("intranet.intranet")

@section("title", "Ausbilder")

@section("content")
    @if($roles->contains('Ausbilder'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Ausbilder</h1>

            <div class="card">
                <div class="text-center">
                    <input class="" type="text" id="searchInput" placeholder="Suchen..." style="width: 50%; height: 3rem" onkeyup="searchCards()"/>
                    <button type="button" class="btn btn-success" data-bs-target="#newuser" data-bs-toggle="modal">Ausbilder Hinzufügen</button>

                    <!-- Modal: Neuen Ausbilder hinzufügen -->
                    <div class="modal fade" id="newuser" tabindex="-1" aria-labelledby="newuser" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/landesschule/ausbilder/new/" method="get">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ausbilder Hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group mb-2">
                                            <label for="discordid">Discord ID:</label>
                                            <input type="number" name="id" id="discordid" class="form-control" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="name">Name:</label>
                                            <input type="text" name="name" id="name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Ausbildungen:</label>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($ausbildungen as $a)
                                                    <input type="checkbox" class="btn-check" name="options[]" value="{{ $a->id }}" id="new_ausbildung_{{ $a->id }}" autocomplete="off">
                                                    <label class="btn btn-outline-primary border p-2" for="new_ausbildung_{{ $a->id }}">{{ $a->name }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                        <button type="submit" class="btn btn-success">Hinzufügen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabelle -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Discord ID</th>
                            <th>Name</th>
                            <th>Ausbildungen letzte 2 Wochen</th>
                            <th>Ausbildungen insgesamt</th>
                            <th>Ausbildungen</th>
                            <th class="opt-header">Optionen</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach($ausbilder as $user)
                            @php
                                $userAusbildungen = json_decode($user->ausbildungen, true) ?? [];
                                $last = \App\Models\ausbildungsangebot::where('ausbilder', $user->id)->where('created_at', '>', \Illuminate\Support\Carbon::now()->subWeeks(2))->count();
                                $insgesamt = \App\Models\ausbildungsangebot::where('ausbilder', $user->id)->count();

                            @endphp
                            <tr class="tr" data="{{ $user->id }} {{ $user->name }}">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $last }}</td>
                                <td>{{ $insgesamt }}</td>
                                <td>
                                    @foreach($ausbildungen as $a)
                                        @if(in_array($a->id, $userAusbildungen))
                                            <span class="badge bg-primary">{{ $a->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="options">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $user->id }}">
                                        Bearbeiten
                                        <i class="bi bi-pencil ms-1"></i>
                                    </button>
                                    <form action="/landesschule/ausbilder/delete/{{ $user->id }}" type="get">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            Löschen
                                            <i class="bi bi-trash ms-1"></i>
                                        </button>
                                    </form>


                                    <!-- Modal: Ausbilder bearbeiten -->
                                    <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                        <form action="/landesschule/ausbilder/edit/{{ $user->id }}" method="get">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Ausbilder Bearbeiten</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label>Name:</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Ausbildungen:</label>
                                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                                @foreach($ausbildungen as $a)
                                                                    @php
                                                                        $checkboxId = 'edit_' . $user->id . '_ausbildung_' . $a->id;
                                                                    @endphp
                                                                    <input type="checkbox" class="btn-check" name="options[]" value="{{ $a->id }}" id="{{ $checkboxId }}" autocomplete="off"
                                                                           @if(in_array($a->id, $userAusbildungen)) checked @endif>
                                                                    <label class="btn btn-outline-primary border p-2" for="{{ $checkboxId }}">{{ $a->name }}</label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success" type="submit">Speichern</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif

    <!-- Suchfunktion -->
    <script>
        function searchCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.tr');

            rows.forEach(row => {
                const text = row.getAttribute('data').toLowerCase();
                row.style.display = text.includes(searchInput) ? '' : 'none';
            });
        }
    </script>

    <!-- Stil -->
    <style>
        .options {
            display: flex;
            flex-flow: row;
            justify-content: flex-end;
            gap: 1rem;
        }
        .opt-header {
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection
