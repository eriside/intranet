@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('Berechtigungen'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Berechtigungen</h1>

            <div class="card">
                <div class="text-center">
                    <input class="" type="text" id="searchInput" placeholder="Suchen..." style="width: 50%; height: 3rem" onkeyup="searchCards()"/>
                    <button type="button" class="btn btn-success" data-bs-target="#newuser" data-bs-toggle="modal">User Hinzufügen</button>
                    <div class="modal fade" id="newuser" tabindex="-1" aria-labelledby="newuser" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/intranet/admin/berechtigung/adduser/" method="get">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">User Hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group d-flex flex-wrap justify-content-start gap-2">
                                            <label for="discordid" class="form-label">Discord ID:</label>
                                            <input type="text" name="id" id="discordid" class="form-control">
                                        </div>
                                        <div class="form-group d-flex flex-wrap justify-content-start gap-2 mt-2">
                                            <label for="discordname" class="form-label">Discord Name:</label>
                                            <input type="text" name="name" id="discordname" class="form-control">
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-start gap-2 form-group mt-2">
                                            @foreach($rollen as $rolle)
                                                <input type="checkbox" class="btn-check" name="options[]" value="{{$rolle->id}}" id="{{$rolle->id}}" autocomplete="off" >
                                                <label class="btn btn-outline-primary border p-3" for="{{$rolle->id}}">{{$rolle->name}}</label>
                                            @endforeach

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
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Discord ID</th>
                                <th scope="col">Discord Name</th>
                                <th scope="col">Name</th>
                                <th scope="col">Berechtigungen</th>
                                <th scope="col" class="opt-header">Optionen</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($users as $user)
                                <tr class="tr" data="{{$user->id}} {{$user->username}} @foreach($namen as $name) @if($name->id == $user->id)  {{$name->name}} @endif @endforeach">

                                <td>{{$user->id}}</td>
                                <td>{{$user->username}}</td>
                                <td>@foreach($namen as $name) @if($name->id == $user->id)  {{$name->name}} @endif @endforeach</td>
                                <td>
                                    @foreach($user->roles()->pluck('name') as $role)
                                        {{$role}},
                                    @endforeach
                                </td>
                                <td class="options">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{$user->id}}">
                                        Bearbeiten
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>
                                    <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
                                        <form action="/intranet/admin/berechtigung/edit/{{$user->id}}" method="post">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="qrCodeModalLabel">User bearbeiten</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="d-flex flex-wrap gap-3">

                                                            <div class="d-flex flex-wrap justify-content-start gap-2 form-group">
                                                                @foreach($rollen as $rolle)
                                                                    @php
                                                                        // Generiere eine eindeutige ID für jedes Benutzer-Rollen-Paar
                                                                        $checkboxId = 'role_' . $rolle->id . '_' . $user->id;
                                                                    @endphp
                                                                    <input type="checkbox" class="btn-check" name="options[]" value="{{$rolle->id}}" id="{{$checkboxId}}" autocomplete="off"
                                                                           @if(in_array($rolle->name, $user->roles()->pluck('name')->toArray())) checked @endif>
                                                                    <label class="btn btn-outline-primary border p-3" for="{{$checkboxId}}">{{$rolle->name}}</label>
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




    <script>
        function searchCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.tr');

            cards.forEach(card => {
                const title = card.getAttribute('data').toLowerCase();
                if (title.includes(searchInput)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    <style>
        .options{
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 1rem;
        }
        .opt-header{
            display: flex;
            justify-content: flex-end;
        }

    </style>
@endsection
