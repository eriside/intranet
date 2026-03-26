@extends("intranet.intranet")

@section("title", "Mitarbeiter bearbeiten")

@section("content")
    @if($roles->contains('Mitarbeiter'))
        <div class="container my-5">
            <h1 class="text-center mb-5">{{$mitarbeiter->name}} bearbeiten</h1>

            <form action="/intranet/verwaltung/mitarbeiter/edit/change/{{$mitarbeiter->id}}" method="POST">
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
                            <label for="arbeitsverhältnis" class="form-label">Arbeitsverhältnis</label>
                            <select class="form-select" id="arbeitsverhältnis" name="arbeitsverhältnis" required>
                                <option value="Ehrenamt" @if($mitarbeiter->arbeitsverhaltnis=="Ehrenamt") selected @endif>Ehrenamt</option>
                                <option value="Vollzeit" @if($mitarbeiter->arbeitsverhaltnis=="Vollzeit") selected @endif>Vollzeit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="geschlecht" class="form-label">Geschlecht:</label>
                            <select class="form-select" id="geschlecht" name="geschlecht" required>
                                <option value="Männlich" @if($mitarbeiter->geschlecht=="Männlich") selected @endif>Männlich</option>
                                <option value="Männlich" @if($mitarbeiter->geschlecht=="Weiblich") selected @endif>Weiblich</option>
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
                            <label for="dienstnummer" class="form-label">Dienstnummer</label>
                            <input type="number" class="form-control" id="dienstnummer" name="dienstnummer" value="{{$mitarbeiter->dienstnummer}}" required>
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
                            <label for="beamtenstatus" class="form-label">Beamtenstatus</label>
                            <select class="form-select" id="beamtenstatus" name="beamtenstatus" required>
                                @php $status = [
                            'Keine Verbeamtung', 'Beamter auf Probe', 'Beamter auf Widerruf',
                            'Beamter auf Zeit', 'Beamter auf Lebenszeit', 'Angestellt'
                        ]; @endphp
                                @foreach($status as $stat)
                                    <option value="{{$stat}}" @if($mitarbeiter->baeamtenstatus == $stat) selected @endif>{{$stat}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>


                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Zweitjob Optionen</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nbz" class="form-label">Nebenjob Zulassung</label>
                            <select class="form-select" id="nbz" name="nbz" required>
                                <option value="1" @if($mitarbeiter->zulassung_nebenjob) selected @endif>Ja</option>
                                <option value="0" @if(!$mitarbeiter->zulassung_nebenjob) selected @endif>Nein</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ort" class="form-label">Ort</label>
                            <input type="text" class="form-control" id="ort" name="nebenjob" value="{{$mitarbeiter->nebenjob }}" >
                        </div>
                        <div class="mb-3">
                            <label for="genehmigt_von" class="form-label">Genehmigt durch</label>
                            <input type="text" class="form-control" id="genehmigt_von" name="nebenjob_von" value="{{$mitarbeiter->nebenjob_von }}" >
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5">Speichern</button>
                    <button type="button" class="btn btn-danger" data-bs-target="#delete" data-bs-toggle="modal">Löschen</button>
                    <button type="button" class="btn btn-warning px-5"><a href="{{url('/intranet/verwaltung/mitarbeiter/view')}}/{{$mitarbeiter->id}}" style="text-decoration: none; color: white">Zurück</a></button>
                </div>
            </form>
        </div>

        <div class="modal fade" id="delete" tabindex="-1">
            <div class="modal-dialog ">
                <div class="modal-content bg-dark">
                    <form action="/intranet/verwaltung/mitarbeiter/delete/{{$mitarbeiter->id}}" method="post">
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
