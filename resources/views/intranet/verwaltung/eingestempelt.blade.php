@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('Eingestempelte Mitarbeiter'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Eingestempelte Mitarbeiter</h1>

            @if($logs->count() != 0) <h4 class="text-center mb-4">Es sind aktuell {{$logs->count()}} eingestempelt</h4>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Eingestempelt</th>
                            <th scope="col">Gesamt</th>
                            <th scope="col" class="opt-header">Optionen</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach($logs as $log)
                            @foreach($namen as $name)
                                @if($name->id == $log->user_id)
                                    <tr>
                                        <td>{{$name->name}}</td>
                                        <td>{{$log->start_time}}</td>
                                        <td>{{\Carbon\Carbon::now()->diff(\Carbon\Carbon::parse($log->start_time))}}</td>
                                        <td class="options"><a class="btn btn-danger" href="{{url('/stempeluhr/')}}/{{$name->id}}/off" style="text-decoration: none">Ausstempeln</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                        </tbody>

                    </table>
                    @else
                        <h4 class="text-center mb-4">Es sind aktuell keine Mitarbeiter eingestempelt</h4>
                    @endif



                </div>
            </div>

        </div>




    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif



    <script>

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
