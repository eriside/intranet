@extends("intranet.intranet")

@section("title", "Ausbildungsangebote")

@section("content")
    @if($isAusbilder)
        <div class="container my-5">
            <h1 class="text-center mb-4">Zeugnisse</h1>

            <div class="card">
                <div class="text-center">


                    <div class="card-body">
                        <form action="/landesschule/sign/" method="get">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select_all">
                                    </th> <!-- Für "Alles auswählen" -->
                                    <th>Ausbildung</th>
                                    <th>Ausbildungs ID</th>
                                    <th>Name</th>
                                    <th>Datum</th>
                                    <th>Ausbilder</th>
                                </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                @foreach($zeugnisse as $zeugniss)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="select_item" name="zeugnis_ids[]" value="{{ $zeugniss->id }}">
                                        </td>
                                        <td>{{ $zeugniss->bezeichnung }}</td>
                                        <td>{{ $zeugniss->ausbildung }}</td>
                                        <td>{{ $zeugniss->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($zeugniss->datum)->format('d.m.Y') }}</td>
                                        <td>{{ $zeugniss->ausbilder }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: left;">
                                <label for="name" class="form-label mt-3">Unterschrift:</label>
                                <input type="text" name="name" id="name" class="form-control mb-3" placeholder="Dein Name hier..." style="max-width: 30%;" required>
                                <button type="submit" class="btn btn-primary">Unterschreiben</button>
                                <button type="button" class="btn btn-success" data-bs-target="#addzeugnis" data-bs-toggle="modal"> Zeugnis Hinzufügen</button>
                            </div>
                        </form>
                        <div class="modal fade" id="addzeugnis" tabindex="-1" aria-labelledby="newuser" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/landesschule/zeugnis/create/" method="get">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Zeugniss Hinzufügen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <label for="mitarbeiter">Mitarbeiter:</label>
                                                <select id="mitarbeiter" class="form-select">
                                                    <option value="">-- Wähle einen Mitarbeiter --</option>
                                                    @foreach($mitarbeiter as $m)
                                                        <option
                                                            value="{{ $m->id }}"
                                                            data-discord="{{ $m->id }}"
                                                            data-geburtsdatum="{{ $m->geburtsdatum }}"
                                                            data-name="{{$m->name}}"
                                                        >
                                                            {{ $m->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mb-2">
                                                <label for="discordid">Discord ID:</label>
                                                <input type="number" name="discordid" id="discordid" class="form-control" required>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="name">Name:</label>
                                                <input type="text" name="name1" id="name1" class="form-control" autocomplete="off" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="geburtsdatum">Geburtsdatum:</label>
                                                <input type="text" name="geburtsdatum" id="geburtsdatum" class="form-control" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="datum">Ausbildungsstart:</label>
                                                <input type="date" name="datum" id="datum" class="form-control" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="ausbilder">Ausbilder:</label>
                                                <select class="form-select" name="ausbilder" id="ausbilder" required>
                                                    @foreach($ausbilder as $a)
                                                        <option value="{{$a->id}}">{{$a->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="ausbildung">Ausbildung:</label>
                                                <select class="form-select" name="ausbildung" id="ausbildung" required>
                                                    @foreach($ausbildungen as $ausbildung)
                                                        <option value="{{$ausbildung->id}}">{{$ausbildung->name}}</option>
                                                    @endforeach
                                                </select>
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


                    <script>
                        document.getElementById('select_all').addEventListener('change', function(e) {
                            const checked = e.target.checked;
                            document.querySelectorAll('.select_item').forEach(function(checkbox) {
                                checkbox.checked = checked;
                            });
                        });
                        document.addEventListener('DOMContentLoaded', function () {
                            const mitarbeiterSelect = document.getElementById('mitarbeiter');
                            const discordInput = document.getElementById('discordid');
                            const nameInput = document.getElementById('name1');
                            const geburtsdatumInput = document.getElementById('geburtsdatum');

                            mitarbeiterSelect.addEventListener('change', function () {
                                const selectedOption = mitarbeiterSelect.options[mitarbeiterSelect.selectedIndex];

                                const discordId = selectedOption.getAttribute('data-discord');
                                const name = selectedOption.getAttribute('data-name');
                                const geburtsdatum = selectedOption.getAttribute('data-geburtsdatum');

                                if (discordId && name && geburtsdatum) {
                                    discordInput.value = discordId;
                                    nameInput.value = name;
                                    geburtsdatumInput.value = geburtsdatum;
                                } else {
                                    discordInput.value = '';
                                    nameInput.value = '';
                                    geburtsdatumInput.value = '';
                                }
                            });
                        });
                    </script>






                </div>
                </div>
            </div>
            @else
                <h1 class="text-center mb-4">Keine Berechtigung</h1>
            @endif



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
