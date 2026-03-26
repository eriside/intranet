@extends("intranet.intranet")

@section("title", "To-Do")
@php
    use Carbon\Carbon;
    $start = Carbon::createFromFormat('Y-m', $aktuellerMonat)->startOfMonth();
    $end = $start->copy()->endOfMonth();
@endphp
@section("content")
    @if($roles->contains('Mitarbeiter'))
        <div class="container my-5 ">
            <h1 class="text-center mb-5">{{$mitarbeiter->name}}</h1>
            <a href="{{url('/intranet/verwaltung/mitarbeiter/edit')}}/{{$mitarbeiter->id}}" class="btn btn-primary mx-auto">Bearbeiten</a>

            <div class="my-5 row mt-4 d-flex align-items-center">
                @php
                    $cards = [
                        ['label' => 'Name', 'value' => $mitarbeiter->name],
                        ['label' => 'Arbeitsverhältnis', 'value' => $mitarbeiter->arbeitsverhaltnis],
                        ['label' => 'Gesamte Dienstzeit', 'value' => "$days Tage $hours Stunden $minutes Minuten"],
                        ['label' => 'Discord ID', 'value' => $mitarbeiter->id],
                        ['label' => 'Telefonnummer', 'value' => $mitarbeiter->telefonnummer],
                        ['label' => 'Nebenjob Zulassung', 'value' => $mitarbeiter->zulassung_nebenjob == 1 ? 'Ja' : 'Nein'],
                        ['label' => 'Nebenjob', 'value' => $mitarbeiter->nebenjob ?? 'Nein'],
                        ['label' => 'Nebenjob Von', 'value' => $mitarbeiter->nebenjob_von ?? 'N.A.'],
                        ['label' => 'Beamtenstatus', 'value' => $mitarbeiter->baeamtenstatus],
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="card col mx-2 mb-3 col-md-3 shadow-sm" style="background-color: #2e3338; border-radius: 12px; border: none;">
                        <div class="card-body py-3 px-4">
                            <p class="card-title mb-1" style="font-weight: bold; color: #cfd8dc;">{{ $card['label'] }}:</p>
                            <p class="card-text mb-0" style="color: #ffffff;">{{ $card['value'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card" style="background-color: #3b4249;">
                <div class="card-body">
                    <h3 class="card-title" style="color:white;">Dienstzeiten</h3>

                    <form method="GET" action="/intranet/verwaltung/mitarbeiter/view/{{$mitarbeiter->id }}">
                        <label for="monat" class="form-label text-white">Monat auswählen:</label>
                        <select name="monat" id="monat" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                            @foreach($monate as $m)
                                <option value="{{ $m['wert'] }}" {{ $m['wert'] == $aktuellerMonat ? 'selected' : '' }}>
                                    {{ $m['anzeige'] }}
                                </option>
                            @endforeach
                        </select>
                    </form>


                    <div class="d-grid" style="grid-template-columns: repeat(7, 1fr); gap: 0.5rem; margin-top: 1rem;">
                        @for ($day = $start->copy(); $day->lte($end); $day->addDay())
                            @php
                                $datum = $day->toDateString();
                                $zeit = $tageMitZeiten[$datum] ?? null;
                                $hatZeit = isset($tageMitZeiten[$datum]);
                            @endphp

                            <div
                                class="text-center p-2 rounded text-white {{ $hatZeit ? 'bg-primary' : 'bg-secondary' }}"
                                @if($hatZeit)
                                    data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ $zeit }}"
                                @endif
                            >
                                {{ $day->day }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div> 


            <div class="card mt-2" style="background-color: #3b4249;">
                <div class="card-body">
                    <h3 class="card-title m-2" style="color:white;">Einträge</h3>
                    <button type="button" class=" m-2 btn btn-success" data-bs-toggle="modal" data-bs-target="#neweintrag">Neuer Eintrag</button>
                    @foreach($eintraege as $eintrag)
                        <div class="card-body card m-2">
                            <h4 class="card-title toggle-eintrag" data-id="{{$eintrag->id}}">
                                {{$eintrag->head}}
                            </h4>

                            <div class="eintrag-body" id="eintrag-{{$eintrag->id}}" style="display: none;">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>
                                            <p class="card-body">{{$eintrag->value}}</p>
                                        </td>
                                        <td class="options">
                                            <button type="button" class="btn btn-danger card-bod" data-bs-toggle="modal" data-bs-target="#deleintrag{{$eintrag->id}}">Löschen</button>
                                            <button type="button" class="btn btn-warning card-bod" data-bs-toggle="modal" data-bs-target="#editeintrag{{$eintrag->id}}">Bearbeiten</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="modal fade" id="deleintrag{{$eintrag->id}}"  tabindex="-1" aria-labelledby="deleintrag{{$eintrag->id}}" aria-hidden="true">
                                <div class="modal-dialog" style="">
                                    <div class="modal-content bg-dark text-light">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newMember">Eintrag löschen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/intranet/verwaltung/mitarbeiter/eintrag/delete/{{$eintrag->id}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Sicher das du den Eintrag löschen willst?</p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                <button type="submit" class="btn btn-danger">Löschen</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <div class="modal fade" id="editeintrag{{$eintrag->id}}"  tabindex="-1" aria-labelledby="editeintrag{{$eintrag->id}}" aria-hidden="true">
                                <div class="modal-dialog" style="max-width: 50%">
                                    <div class="modal-content bg-dark text-light">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="newMember">Eintrag erstellen</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/intranet/verwaltung/mitarbeiter/eintrag/edit/{{$eintrag->id}}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="name">Titel:</label>
                                                    <input type="text" class="form-control" id="titel" name="titel" value="{{$eintrag->head}}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="einsatzlage">Beschreibung:</label>
                                                    <textarea id="value" class="form-control" name="value" rows="4" >{{$eintrag->value}}</textarea>
                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                <button type="submit" class="btn btn-primary">Speichern</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>


            
            <!---<div class="card mt-2" style="background-color: #3b4249;">
                <div class="card-body">
                    <h3 class="card-title" style="color:white;">Urlaubsanfragen</h3>
                        <table class="table text-white mt-3">
                            <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Bis</th>
                                <th>Genehmigt von</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($urlaub as $u)
                                    <tr>
                                        <td>{{$u->created_at->format('d.m.Y')}}</td>
                                        <td>{{Carbon::parse($u->bis)->format('d.m.Y')}}</td>
                                        <td>{{$u->genehmigt}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>
            </div>--->

            <!--- todo add 
            <div class="card mt-2" style="background-color: #3b4249;">
                <div class="card-body">
                    <h3 class="card-title" style="color:white;">Schranklogs</h3>

                    <form method="GET">
                        <label for="lagerMonat" class="form-label text-white">Monat auswählen:</label>
                        <select name="lagerMonat" id="lagerMonat" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                            @foreach($lagermonate as $m)
                                <option value="{{ $m['wert'] }}" {{ request('lagerMonat', now()->format('Y-m')) == $m['wert'] ? 'selected' : '' }}>
                                    {{ $m['anzeige'] }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <table class="table text-white mt-3">
                        <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Artikel</th>
                            <th>Menge</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($schrankLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                <td>{{ $log->value }}</td>
                                <td>{{ $log->anzahl }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Keine Entnahmen in diesem Monat.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>


                </div>
            </div>--->

            <div class="card mt-2" style="background-color: #3b4249;">
                <div class="card-body">
                    <h3 class="card-title" style="color:white;">Dokumente</h3>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newDoc">Hochladen</button>
                    <table class="table card-body">
                        <thead>
                            <th scope="col">Dokumententyp</th>
                            <th scope="col">Dokumentenname</th>
                            <th scope="col" class="opt">Optionen</th>
                        </thead>
                        <tbody>
                            @foreach($dokumente as $dokument)
                                <tr>
                                    <td>
                                        @foreach($typen as $typ)
                                            @if($typ->id == $dokument->type)
                                                {{$typ->art}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{$dokument->name}}</td>
                                    <td class="options">
                                        <form action="/intranet/verwaltung/mitarbeiter/dokument/view/{{$dokument->id}}" type="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Ansehen</button>
                                        </form>
                                        <form action="/intranet/verwaltung/mitarbeiter/dokument/download/{{$dokument->id}}" type="get">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Download</button>
                                        </form>

                                        <button type="submit" class="btn btn-danger" data-bs-target="#deletedoc{{$dokument->id}}" data-bs-toggle="modal">Löschen</button>

                                        <div class="modal fade" id="deletedoc{{$dokument->id}}"  tabindex="-1" aria-labelledby="deletedoc{{$dokument->id}}" aria-hidden="true">
                                            <div class="modal-dialog" style="">
                                                <div class="modal-content bg-dark text-light">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newMember">Dokument Löschen</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="/intranet/verwaltung/mitarbeiter/dokument/delete/{{$dokument->id}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <p>Sicher das du das Dokument löschen willst?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                                            <button type="submit" class="btn btn-danger">Löschen</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>

        <div class="modal fade" id="neweintrag"  tabindex="-1" aria-labelledby="neweintrag" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 80%">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMember">Eintrag erstellen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/intranet/verwaltung/mitarbeiter/eintrag/new/{{$mitarbeiter->id}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Titel:</label>
                                <input type="text" class="form-control" id="titel" name="titel" required>
                            </div>


                            <div class="form-group">
                                <label for="einsatzlage">Beschreibung:</label>
                                <textarea id="value" class="form-control" name="value" rows="4"></textarea>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="newDoc"  tabindex="-1" aria-labelledby="newDoc" aria-hidden="true">
            <div class="modal-dialog" style="">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMember">Dokument Hochladen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/intranet/verwaltung/mitarbeiter/dokument/new/{{$mitarbeiter->id}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                            <div class="form-group mb-3">
                                <label for="Einsatznummer">Dokumentenname</label>
                                <input type="text" class="form-control" id="dokumentenname" name="dokumentenname" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="stichwort">Dokumententyp</label>
                                <select class="form-select" id="dokumententyp" name="dokumententyp" required>
                                    @foreach($typen as $dokumentenyp)
                                        <option value="{{$dokumentenyp->id}}" >{{$dokumentenyp->art}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group mb-3">
                                <label for="image">Dokument hochladen</label>
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="formFile" name="file" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-eintrag').forEach(function (header) {
                header.addEventListener('click', function () {
                    const id = header.getAttribute('data-id');
                    const body = document.getElementById('eintrag-' + id);
                    if (body.style.display === 'none') {
                        body.style.display = 'block';
                    } else {
                        body.style.display = 'none';
                    }
                });
            });
        });
    </script>
    <style>
        .options{
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 1rem;
        }
        .opt{
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: center;
            gap: 1rem;
        }

    </style>
    <style>
        .card-custom {
            background-color: #2d3238;
            border-radius: 1rem;
            color: white;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        }

        .section-title {
            color: #ffffff;
            margin-bottom: 1rem;
            border-bottom: 2px solid #5a6268;
            padding-bottom: 0.5rem;
        }

        .form-label, .form-select, .btn, .modal-content {
            border-radius: 0.5rem;
        }

        .table thead {
            color: #adb5bd;
        }

        .table tbody {
            color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .rounded-calendar-day {
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .rounded-calendar-day:hover {
            filter: brightness(90%);
            cursor: pointer;
        }

        .options .btn {
            margin-right: 0.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .eintrag-body {
            border-radius: 0.5rem;
            padding: 1rem;
        }
    </style>

@endsection
