@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")

    @if($roles->contains('Stempeluhr Log'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Stempeluhr Log</h1>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Eingestempelt</th>
                            <th scope="col">Ausgestempelt</th>
                            <th scope="col">Gesamt</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach($logs as $log)
                            @php
                                $name = $namen[$log->user_id]->name ?? 'Unbekannt';
                                $start = \Carbon\Carbon::parse($log->start_time);
                                $end = \Carbon\Carbon::parse($log->end_time);
                            @endphp
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $name }}</td>
                                <td>{{ $log->start_time }}</td>
                                <td>{{ $log->end_time }}</td>
                                <td>{{ $end->diff($start)->format('%H:%I:%S') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif

@endsection

@section("styles")
    <style>

        .options {
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 1rem;
        }
        .opt-header {
            display: flex;
            justify-content: flex-end;
        }
    </style>
@endsection
