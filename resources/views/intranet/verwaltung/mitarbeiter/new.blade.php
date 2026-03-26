@extends("intranet.intranet")

@section("title", "Mitarbeiter bearbeiten")

@section("content")
    @if($roles->contains('Mitarbeiter'))
        <div class="container my-5">
            <h1 class="text-center mb-5">Mitarbeiter Erstellen</h1>

            <form action="/intranet/verwaltung/mitarbeiter/newm/" method="get">
                @csrf


                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Profildaten</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Name</label>
                            <input type="text" class="form-control" id="username" name="name"  required>
                        </div>
                        <div class="mb-3">
                            <label for="id" class="form-label">Discord ID</label>
                            <input type="number" class="form-control" id="id" name="id">
                        </div>
                        <div class="mb-3">
                            <label for="geburtsdatum" class="form-label">Geburtsdatum</label>
                            <input type="text" class="form-control" id="geburtsdatum" name="geburtsdatum"  required>
                        </div>
                        <div class="mb-3">
                            <label for="aktiv" class="form-label">Aktiv</label>
                            <select class="form-select" id="aktiv" name="aktiv" required>
                                <option value="1" >Ja</option>
                                <option value="0" >Nein</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="arbeitsverhältnis" class="form-label">Arbeitsverhältnis</label>
                            <select class="form-select" id="arbeitsverhältnis" name="arbeitsverhältnis" required>
                                <option value="Ehrenamt" >Ehrenamt</option>
                                <option value="Vollzeit" >Vollzeit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="geschlecht" class="form-label">Geschlecht:</label>
                            <select class="form-select" id="geschlecht" name="geschlecht" required>
                                <option value="Männlich">Männlich</option>
                                <option value="Männlich">Weiblich</option>
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
                            <input type="number" class="form-control" id="dienstnummer" name="dienstnummer"  required>
                        </div>
                        <div class="mb-3">
                            <label for="telefonnummer" class="form-label">Telefonnummer</label>
                            <input type="number" class="form-control" id="telefonnummer" name="telefonnummer" required>
                        </div>
                        <!---<div class="mb-3">
                            <label for="iban" class="form-label">IBAN</label>
                            <input type="text" class="form-control" id="iban" name="iban" required>
                        </div>--->
                        <div class="mb-3">
                            <label for="beamtenstatus" class="form-label">Beamtenstatus</label>
                            <select class="form-select" id="beamtenstatus" name="beamtenstatus" required>
                                @php $status = [
                            'Keine Verbeamtung', 'Beamter auf Probe', 'Beamter auf Widerruf',
                            'Beamter auf Zeit', 'Beamter auf Lebenszeit', 'Angestellt'
                        ]; @endphp
                                @foreach($status as $stat)
                                    <option value="{{$stat}}" >{{$stat}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>




                <div class="text-center">
                    <button type="submit" class="btn btn-success px-5">Hinzufügen</button>
                    <button type="button" class="btn btn-danger px-5"><a href="{{url('/intranet/verwaltung/mitarbeiter')}}" style="text-decoration: none; color: white">Zurück</a></button>
                </div>
            </form>
        </div>
    @else
        <h1 class="text-center my-5 text-danger">Keine Berechtigung</h1>
    @endif
@endsection
