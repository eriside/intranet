@extends("welcome")

@section("title", "Leitung Dashboard")

@section("content")
    <div class="container mt-5">
        <h2 class="text-center mb-4">Leitungs Team</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newMember">Neues Mitglied</button>
        <div class="modal fade" id="newMember" tabindex="-1" aria-labelledby="newMember" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newMember">Mitglied erstellen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ url('/dashboard/leitung/new/') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="role">Rolle</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="Direktor der Berufsfeuerwehr" >Direktor der Berufsfeuerwehr</option>
                                    <option value="Ärztlicher Leiter Rettungsdienst" >Ärztlicher Leiter Rettungsdienst</option>
                                    <option value="Leitender Branddirektor" >Leitender Branddirektor</option>
                                    <option value="Verwaltungsleitung" >Verwaltungsleitung</option>
                                    <option value="Verwalter" selected>Verwalter</option>
                                    <option value="Branddirektor" >Branddirektor</option>
                                    <option value="Direktor des kindergartens" >Direktor des kindergartens</option>

                                </select>
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
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach($leitung as $member)
                <div class="col">
                    <div class="card shadow-lg border-0 rounded" >
                        <img src="{{asset('images/'.$member->image)}}" class="card-img-top" alt="{{ $member->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $member->name }}</h5>
                            <p class="card-text">{{ $member->rolle }}</p>
                            <table class="table table-borderless">
                                <tr>
                                    <th>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $member->id }}">Bearbeiten</button>
                                    </th>
                                    <th>
                                        <form action="{{url('/dashboard/leitung/delete/' . $member->id)}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Löschen</button>
                                        </form>
                                    </th>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editModal{{ $member->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $member->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content bg-dark text-light">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $member->id }}">Mitglied bearbeiten</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ url('/dashboard/leitung/edit/' . $member->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="role">Rolle</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="Direktor der Berufsfeuerwehr" {{ $member->rolle == 'Direktor der Berufsfeuerwehr' ? 'selected' : '' }}>Direktor der Berufsfeuerwehr</option>
                                            <option value="Ärztlicher Leiter Rettungsdienst" {{ $member->rolle == 'Ärztlicher Leiter Rettungsdienst' ? 'selected' : '' }}>Ärztlicher Leiter Rettungsdienst</option>
                                            <option value="Leitender Branddirektor" {{ $member->rolle == 'Leitender Branddirektor' ? 'selected' : '' }}>Leitender Branddirektor</option>
                                            <option value="Verwaltungsleitung" {{ $member->rolle == 'Verwaltungsleitung' ? 'selected' : '' }}>Verwaltungsleitung</option>
                                            <option value="Verwalter" {{ $member->rolle == 'Verwalter' ? 'selected' : '' }}>Verwalter</option>
                                            <option value="stv. Ärztlicher Leiter Rettungsdienst" {{ $member->rolle == 'stv. Ärztlicher Leiter Rettungsdienst' ? 'selected' : '' }}>stv. Ärztlicher Leiter Rettungsdienst</option>
                                            <option value="Branddirektor" {{ $member->rolle == 'Branddirektor' ? 'selected' : '' }}>Branddirektor</option>
                                            <option value="Entwicklungsleitung" {{ $member->rolle == 'Entwicklungsleitung' ? 'selected' : '' }}>Entwicklungsleitung</option>
                                            <option value="Direktor des kindergartens" {{ $member->rolle == 'Direktor des kindergartens' ? 'selected' : '' }}>Direktor des kindergartens</option>

                                        </select>
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
        height: 100%;
        border-radius: 15px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        background-color: #fff;
        flex-grow: 1;
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
    }

    .card-text {
        color: #7f8c8d;
        font-size: 16px;
        margin-bottom: 15px;
    }




    /* Modal Styling */
    .modal-content {
        background-color: #34495e;
        color: #fff;
    }

    .modal-header {
        border-bottom: 1px solid #2c3e50;
    }

    .form-select, .form-control {
        background-color: #2c3e50;
        color: #fff;
        border-radius: 5px;
        border: 1px solid #7f8c8d;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .row-cols-1 .col {
            margin-bottom: 20px;
        }
    }

</style>

