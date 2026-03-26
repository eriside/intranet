@extends("intranet.intranet")

@section("title", "Ausbildungsangebote")

@section("content")
    @if($isAusbilder and $ausbildung->ausbilder == \Illuminate\Support\Facades\Auth::user()->id)
        <div class="container my-5">
            <h1 class="text-center mb-4">Ausbildungsangebot {{$ausbildung->id}}</h1>
            <h4 class="text-center mb-4">
                @foreach($asubildungen as $a)
                    @if($a->id == $ausbildung->ausbildung) {{$a->name}}@endif
                @endforeach
            </h4>

            <div class="card">
                <div class="text-center">


                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Teilnehmer</th>
                            <th>Geburtsdatum</th>
                            <th class="opt-header">Optionen</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach(json_decode($ausbildung->teilnehmer) as $teilnehmer)
                            @if($teilnehmer->bestanden===null)
                                <tr>
                                    <td>
                                        {{$teilnehmer->name}}
                                    </td>
                                    <td>
                                        {{$teilnehmer->geburtsdatum}}
                                    </td>
                                    <td class="options">
                                        <form action="/landesschule/ausbildungsangebote/pass/{{$ausbildung->id}}/{{$teilnehmer->id}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Bestanden</button>
                                        </form>
                                        <form action="/landesschule/ausbildungsangebote/fail/{{$ausbildung->id}}/{{$teilnehmer->id}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Durchgefallen</button>
                                        </form>
                                    </td>

                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
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
