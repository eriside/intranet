@extends("intranet.intranet")

@section("title", "Ausbildungsangebote")

@section("content")
    @if($isAusbilder)
        <div class="container my-5">
            <h1 class="text-center mb-4">Ausbildungsangebote</h1>

            <div class="card">
                <div class="text-center">


                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Ausbildung</th>
                            <th>Datum</th>
                            <th class="opt-header">Weiteres</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($ausbildungsangebote as $a)
                                <tr>
                                    <td>
                                        @foreach($ausbildungen as $ausbildung)
                                            @if($ausbildung->id == $a->ausbildung) {{$ausbildung->name}} @endif
                                        @endforeach
                                    </td>
                                    <td>{{$a->created_at->format('d.m.Y')}}</td>
                                    <td class="options">
                                        <form action="/landesschule/ausbildungsangebote/view/{{$a->id}}" method="get">
                                            @csrf
                                            <button type="submit" class="btn btn-success"><i class="fas fa-eye"></i> Ansehen</button>
                                        </form>
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
