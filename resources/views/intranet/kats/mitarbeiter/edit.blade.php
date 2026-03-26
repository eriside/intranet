@extends("intranet.intranet")

@section("title", "Mitarbeiter bearbeiten")

@section("content")
    @if($roles->contains('Kats'))
        <div class="container my-5">
            <h1 class="text-center mb-5">{{$mitarbeiter->name}} bearbeiten</h1>

            <form action="/intranet/kats/mitarbeiter/edit/change/{{$mitarbeiter->id}}" method="POST">
                @csrf


                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Profildaten</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" class="form-control" id="username" name="name" value="{{$mitarbeiter->name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="vorname" class="form-label">Vorname</label>
                            <input type="text" class="form-control" id="vorname" name="vorname" value="{{$mitarbeiter->vorname}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">Discord ID</label>
                            <input type="text" class="form-control" id="id" value="{{$mitarbeiter->id}}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="geburtsdatum" class="form-label">Geburtsdatum</label>
                            <input type="text" class="form-control" id="geburtsdatum" name="geburtsdatum" value="{{$mitarbeiter->geburtsdatum}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="aktiv" class="form-label">Aktiv</label>
                            <select class="form-select" id="aktiv" name="aktiv" required>
                                <option value="1" @if($mitarbeiter->aktiv) selected @endif>Ja</option>
                                <option value="0" @if(!$mitarbeiter->aktiv) selected @endif>Nein</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="geschlecht" class="form-label">Geschlecht:</label>
                            <select class="form-select" id="geschlecht" name="geschlecht" required>
                                <option value="Männlich" @if($mitarbeiter->geschlecht == 'Männlich') selected @endif>Männlich</option>
                                <option value="Weiblich" @if($mitarbeiter->geschlecht == 'Weiblich') selected @endif>Weiblich</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Optionale Angaben</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{$mitarbeiter->email}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefonnummer" class="form-label">Telefonnummer</label>
                            <input type="number" class="form-control" id="telefonnummer" name="telefonnummer" value="{{$mitarbeiter->telefonnummer}}" required>
                        </div>
                        <!---<div class="mb-3">
                            <label for="iban" class="form-label">IBAN</label>
                            <input type="text" class="form-control" id="iban" name="iban" value="{{$mitarbeiter->iban}}" required>
                        </div>--->
                        <div class="mb-3">
                            <label for="führerscheinklassen" class="form-label">Führerscheinklassen</label>
                            <input type="text" class="form-control" id="führerscheinklassen" name="führerscheinklassen" value="{{$mitarbeiter->führerscheinklassen}}" required>
                        </div>

                    </div>
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5">Speichern</button>
                    <button type="button" class="btn btn-danger" data-bs-target="#delete" data-bs-toggle="modal">Löschen</button>
                    <button type="button" class="btn btn-warning px-5"><a href="{{url('/intranet/kats/mitarbeiter/view')}}/{{$mitarbeiter->id}}" style="text-decoration: none; color: white">Zurück</a></button>
                </div>
            </form>
        </div>

        <div class="modal fade" id="delete" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content bg-dark">
                    <form action="/intranet/kats/mitarbeiter/delete/{{$mitarbeiter->id}}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Mitarbeiter Löschen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Sicher das du den Mitarbeiter löschen willst?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-danger">Löschen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-center my-5 text-danger">Keine Berechtigung</h1>
    @endif
@endsection
