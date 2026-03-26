@extends("intranet.intranet")

@section("title", "Rollen")

@section("content")
    @if($roles->contains('Berechtigungen'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Rollen</h1>

            <div class="card">
                <div class="text-center">
                    <input class="" type="text" id="searchInput" placeholder="Suchen..." style="width: 50%; height: 3rem" onkeyup="searchCards()"/>
                    <button type="button" class="btn btn-success" data-bs-target="#newrole" data-bs-toggle="modal">Rolle Hinzufügen</button>
                    <div class="modal fade" id="newrole" tabindex="-1" aria-labelledby="newrole" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/intranet/admin/rollen/addrole/" method="get">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">User Hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group d-flex flex-wrap justify-content-start gap-2">
                                            <label for="name" class="form-label">Name:</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label class="form-label">Discord Rollen:</label>
                                            <div id="discord-roles-container" class="d-flex flex-column gap-2">
                                                <div class="input-group">
                                                    <input type="number" name="discord_roles[]" class="form-control" placeholder="Discord Rollen-ID">
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-secondary mt-2" onclick="addDiscordRoleInput()">Weitere Rolle hinzufügen</button>
                                        </div>

                                        <div class="d-flex flex-wrap justify-content-start gap-2 form-group mt-2">
                                            @foreach($berechtigungen as $rolle)
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
                                <th scope="col">Name</th>
                                <th scope="col">Discord Rollen</th>
                                <th scope="col">Berechtigungen</th>
                                <th scope="col" class="opt-header">Optionen</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($funktionen as $funktion)
                                <tr data-name="{{$funktion->name}}">
                                    <td>{{$funktion->name}}</td>
                                    <td>
                                        @foreach ($funktion->discord_roles_data as $role)
                                            <span class="badge bg-primary" data-role-id="{{ $role['id'] }}">
                                                {{ $role['name'] }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($berechtigungen as $ber)
                                            @foreach($funktion->berechtigungen as $berrole)
                                                @if($berrole == $ber->id)
                                                    {{$ber->name}},
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td class="options">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $funktion->id }}">
                                            Bearbeiten
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $funktion->id }}">
                                            Löschen
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6zm2 .5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1h3a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11z"/>
                                            </svg>
                                        </button>
                                        <div class="modal fade" id="editRoleModal-{{ $funktion->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="/intranet/admin/rollen/update/{{ $funktion->id }}" method="GET">
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Rolle bearbeiten: {{ $funktion->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-2">
                                                                <label for="name-{{ $funktion->id }}">Name</label>
                                                                <input type="text" name="name" id="name-{{ $funktion->id }}" value="{{ $funktion->name }}" class="form-control">
                                                            </div>

                                                            <div class="form-group mb-2">
                                                                <label>Discord Rollen:</label>
                                                                <div id="discord-roles-edit-{{ $funktion->id }}" class="d-flex flex-column gap-2">
                                                                    @foreach ($funktion->discord_roles_data as $role)
                                                                        <div class="input-group">
                                                                            <input type="number" name="discord_roles[]" class="form-control" value="{{ $role['id'] }}">
                                                                            <span class="input-group-text">{{ $role['name'] }}</span>
                                                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">×</button>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <button type="button" class="btn btn-outline-secondary mt-2" onclick="addDiscordRoleInput('{{ $funktion->id }}')">Weitere Rolle hinzufügen</button>
                                                            </div>

                                                            <div class="form-group mt-2 d-flex flex-wrap gap-2">
                                                                @foreach($berechtigungen as $rolle)
                                                                    <input type="checkbox" class="btn-check" name="options[]" value="{{ $rolle->id }}"
                                                                           id="edit-{{ $funktion->id }}-{{ $rolle->id }}"
                                                                        {{ in_array($rolle->id, $funktion->berechtigungen) ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary p-2" for="edit-{{ $funktion->id }}-{{ $rolle->id }}">
                                                                        {{ $rolle->name }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                                                            <button type="submit" class="btn btn-success">Speichern</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="deleteRoleModal-{{ $funktion->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="/intranet/admin/rollen/delete/{{ $funktion->id }}" method="GET">
                                                        @csrf

                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">Rolle löschen: {{ $funktion->name }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Schließen"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Bist du sicher, dass du die Rolle <strong>{{ $funktion->name }}</strong> löschen möchtest? Diese Aktion kann nicht rückgängig gemacht werden.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
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
        function searchCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('tbody tr');

            cards.forEach(card => {
                const title = card.dataset.name.toLowerCase();
                if (title.includes(searchInput)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function addDiscordRoleInput(funktionId = null) {
            const container = funktionId
                ? document.getElementById(`discord-roles-edit-${funktionId}`)
                : document.getElementById('discord-roles-container');

            const wrapper = document.createElement('div');
            wrapper.className = 'input-group';

            const input = document.createElement('input');
            input.type = 'number';
            input.name = 'discord_roles[]';
            input.className = 'form-control';
            input.placeholder = 'Discord Rollen-ID';

            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline-danger';
            button.innerHTML = '&times;';
            button.onclick = function () {
                container.removeChild(wrapper);
            };

            const btnWrapper = document.createElement('div');
            btnWrapper.className = 'input-group-append';
            btnWrapper.appendChild(button);

            wrapper.appendChild(input);
            wrapper.appendChild(btnWrapper);

            container.appendChild(wrapper);
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
