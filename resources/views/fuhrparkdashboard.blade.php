@extends("welcome")

@section("title", "FuhrparkDashboard")

@section("content")
    <div class="container">
        <h2 class="text-center mb-4">Fuhrpark Verwaltung</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMember">Neues Fahrzeug</button>
        <div class="modal fade" id="newMember" tabindex="-1" aria-labelledby="newMember" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMember">Fahrzeug erstellen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('/dashboard/fuhrpark/new/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Neues Bild hochladen</label>
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="formFile" name="image" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($fahrzeuge as $fahrzeug)
                <div class="col">
                    <div class="card shadow-lg border-0 rounded bg-dark text-light" >
                        <img src="{{asset('images/'.$fahrzeug->image)}}" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{$fahrzeug->name}}</h5>
                            <table class="table table-borderless">
                                <tr >
                                    <th class="bg-dark">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $fahrzeug->id }}">Bearbeiten</button>
                                    </th>
                                    <th class="bg-dark">
                                        <form action="{{url('/dashboard/fuhrpark/delete/' . $fahrzeug->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Löschen</button>
                                        </form>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editModal{{ $fahrzeug->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $fahrzeug->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-light">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $fahrzeug->id }}">Fahrzeug bearbeiten</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/dashboard/fuhrpark/edit/' . $fahrzeug->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $fahrzeug->name }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="image">Neues Bild hochladen</label>
                                        <div class="mb-3">
                                            <input class="form-control" type="file" id="formFile" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                                    <button type="submit" class="btn btn-primary">Speichern</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>

    .row-cols-1 .col,
    .row-cols-md-4 .col {
        display: flex;
        flex-direction: column;
    }

    .card {
        flex-grow: 1;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }



    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }



    .modal-content {
        background-color: #34495e;
        color: #fff;
    }

    .modal-header {
        border-bottom: 1px solid #2c3e50;
    }


    @media (max-width: 768px) {
        .row-cols-1 .col {
            margin-bottom: 20px;
        }
    }

</style>


