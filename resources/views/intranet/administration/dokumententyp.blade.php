@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")

    @if($roles->contains('Dokumententyp'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Dokumententyp</h1>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Art</th>
                            <th scope="col" class="opt-header">Optionen</th>
                        </tr>
                        </thead>
                        <tbody class="table-group-divider">
                        @foreach($arten as $art)
                            <tr>
                                <td>{{$art->id}}</td>
                                <td>{{$art->art}}</td>
                                <td class="options">

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{$art->id}}">
                                        Bearbeiten
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </button>
                                    <form action="/intranet/admin/dokumententyp/delete/{{$art->id}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            Löschen
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <div class="modal fade" id="edit{{$art->id}}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
                                        <form action="/intranet/admin/dokumententyp/edit/{{$art->id}}" method="post">
                                            @csrf
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="qrCodeModalLabel">User bearbeiten</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="d-flex flex-wrap gap-3">

                                                            <div class="d-flex flex-wrap gap-3">

                                                                <div class="form-group mb-3">
                                                                    <label for="name">Name</label>
                                                                    <input type="text" class="form-control" id="name" name="art" value="{{$art->art}}" required>
                                                                </div>
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
                            @endforeach
                            </tbody>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#neu">Neu Hinzufügen</button>

                    <div class="modal fade" id="neu" tabindex="-1" aria-labelledby="neu" aria-hidden="true">
                        <form action="/intranet/admin/dokumententyp/new" method="post">
                            @csrf
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="qrCodeModalLabel">Typ hinzufügen</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex flex-wrap gap-3">

                                            <div class="form-group mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="art" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit">Hinzufügen</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>


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
