@extends("intranet.intranet")

@section("title", "Kats Mitarbeiter")

@section("content")
    @if($roles->contains('Kats'))
        <div class="container my-5 ">
            <h1 class="text-center mb-5">{{$mitarbeiter->name}}</h1>
            <a href="{{url('/intranet/kats/mitarbeiter/edit')}}/{{$mitarbeiter->id}}" class="btn btn-primary mx-auto">Bearbeiten</a>

            <div class="my-5 row mt-4 d-flex align-items-center">
                @php
                    $cards = [
                        ['label' => 'Name', 'value' => $mitarbeiter->name],
                        ['label' => 'Vorname', 'value' => $mitarbeiter->vorname],
                        ['label' => 'Discord ID', 'value' => $mitarbeiter->id],
                        ['label' => 'Telefonnummer', 'value' => $mitarbeiter->telefonnummer],
                        ['label' => 'email', 'value' => $mitarbeiter->email],
                        ['label' => 'Fürherscheinklassen', 'value' => $mitarbeiter->führerscheinklassen],
                        ['label' => 'Geschlecht', 'value' => $mitarbeiter->geschlecht],
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



            <div class="modal fade" id="newDoc"  tabindex="-1" aria-labelledby="newDoc" aria-hidden="true">
                <div class="modal-dialog" style="">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newMember">Dokument Hochladen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/intranet/kats/mitarbeiter/dokument/new/{{$mitarbeiter->id}}" method="POST" enctype="multipart/form-data">
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
                                    <form action="/intranet/kats/mitarbeiter/dokument/view/{{$dokument->id}}" type="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Ansehen</button>
                                    </form>
                                    <form action="/intranet/kats/mitarbeiter/dokument/download/{{$dokument->id}}" type="get">
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
                                                <form action="/intranet/kats/mitarbeiter/dokument/delete/{{$dokument->id}}" method="POST" enctype="multipart/form-data">
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
