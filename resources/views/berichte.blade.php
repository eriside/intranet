@extends("welcome")

@section("title", "Berichte")

@section("content")
    <div class="container mt-4">
        <h2 class="mb-4">Berichtsliste</h2>

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h5>Berichtsinformationen</h5>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#newBericht">Neuer Bericht</button>
                @if($isleitung)
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#fahrzeugubersicht">Fahrzeug Übersicht</button>

                @endif
            </div>
            <div class="modal fade" id="fahrzeugubersicht"  tabindex="-1" aria-labelledby="fahrzeugubersicht" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 80%">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newMember">Fahrzeug Übersicht</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Optionen</th>
                                        </tr>
                                    </thead>
                                    @foreach($fahrzeuge as $fahrzeug)
                                        <tr>
                                            <td>{{$fahrzeug->id}}</td>
                                            <td>{{$fahrzeug->name}}</td>
                                            <td class="options">
                                                <form action="/dashboard/berichte/deleteFahrzeug/{{$fahrzeug->id}}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        Löschen
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <form action="/dashboard/berichte/newFahrzeug/" method="POST">
                                            @csrf
                                            <td>Neu</td>
                                            <td><input name="name"></td>
                                            <td class="options">
                                                <button type="submit" class="btn btn-primary">Speichern</button>
                                            </td>

                                        </form>
                                    </tr>
                                </table>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="newBericht"  tabindex="-1" aria-labelledby="newBericht" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 80%">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="newMember">Bericht erstellen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/dashboard/berichte/new/') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="name">Author:</label>
                                    <input type="text" class="form-control" id="name" name="author" value="{{$nickname}}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="Einsatznummer">Einsatznummer</label>
                                    <input type="text" class="form-control" id="Einsatznummer" name="einsatznummer" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Datum:</label>
                                    <input type="text" class="form-control" id="datum" name="datum" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="uhrzeit">Uhrzeit:</label>
                                    <input type="text" class="form-control" id="uhrzeit" name="uhrzeit" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="stichwort">Einsatz Stichwort</label>
                                    <select class="form-select" id="stichwort" name="stichwort" required>
                                        <option value="Feuer 1 - Verkehr" >Feuer 1 - Verkehr</option>
                                        <option value="Feuer 1 - im Freien" >Feuer 1 - im Freien</option>
                                        <option value="Feuer 2 - im Freien" >Feuer 2 - im Freien</option>
                                        <option value="Feuer 2 - Verkehr" >Feuer 2 - Verkehr</option>
                                        <option value="Feuer 2 - im Gebäude">Feuer 2 - im Gebäude</option>
                                        <option value="Feuer 2 - Alarmstufenerhöhung" >Feuer 2 - Alarmstufenerhöhung</option>
                                        <option value="Feuer 2 MiG - im Freien" >Feuer 2 MiG - im Freien</option>
                                        <option value="Feuer 2 MiG - Verkehr" >Feuer 2 MiG - Verkehr</option>
                                        <option value="Feuer 2 MiG - Alarmstufenerhöhung" >Feuer 2 MiG - Alarmstufenerhöhung</option>
                                        <option value="Feuer 3 - im Freien" >Feuer 3 - im Freien</option>
                                        <option value="Feuer 3 - im Gebäude" >Feuer 3 - im Gebäude</option>
                                        <option value="Feuer 3 - Verkehr" >Feuer 3 - Verkehr</option>
                                        <option value="Feuer 3 - Alarmstufenerhöhung" >Feuer 3 - Alarmstufenerhöhung</option>
                                        <option value="Feuer 3 MiG - im Freien" >Feuer 3 MiG - im Freien</option>
                                        <option value="Feuer 3 MiG - im Gebäude" >Feuer 3 MiG - im Gebäude</option>
                                        <option value="Feuer 3 MiG - Verkehr" >Feuer 3 MiG - Verkehr</option>
                                        <option value="Feuer 3 MiG - Alarmstufenerhöhung" >Feuer 3 MiG - Alarmstufenerhöhung</option>
                                        <option value="Feuer 4 MiG - Alarmstufenerhöhung" >Feuer 4 MiG - Alarmstufenerhöhung</option>
                                        <option value="Feuer BMA" >Feuer BMA</option>
                                        <option value="TH 0" >TH 0</option>
                                        <option value="TH 1" >TH 1</option>
                                        <option value="TH 1 Y" >TH 1 Y</option>
                                        <option value="TH 2" >TH 2</option>
                                        <option value="TH GEFAHR 1" >TH GEFAHR 1</option>
                                        <option value="TH GEFAHR 2" >TH GEFAHR 2</option>
                                        <option value="TH KLEMM 1 Y" >TH KLEMM 1 Y</option>
                                        <option value="TH KLEMM 2 Y" >TH KLEMM 2 Y</option>
                                        <option value="TH WASS Y" >TH WASS Y</option>
                                        <option value="TH WASS 2" >TH WASS 2</option>
                                        <option value="R0" >R0</option>
                                        <option value="R1" >R1</option>
                                        <option value="R2" >R2</option>
                                        <option value="MANV" >MANV</option>
                                        <option value="ABC GEFAHR 1" >ABC GEFAHR 1</option>
                                        <option value="ABC GEFAHR 2" >ABC GEFAHR 2</option>
                                        <option value="Auftrag" >Auftrag</option>
                                        <option value="Alarm" >Alarm</option>
                                    </select>
                                </div>
                                <div class="d-flex flex-wrap justify-content-start gap-2 form-group">
                                    @foreach($fahrzeuge as $fahr)
                                        <input type="checkbox" class="btn-check" name="options[]" value="{{$fahr->name}}" id="{{$fahr->name}}" autocomplete="off">
                                        <label class="btn btn-outline-warning border p-3" for="{{$fahr->name}}">{{$fahr->name}}</label>
                                    @endforeach

                                </div>

                                <div class="form-group">
                                    <label for="einsatzlage">Einsatzlage:</label>
                                    <textarea id="einsatzlage" class="form-control" name="einsatzlage" rows="4" placeholder="Beschreibung der Einsatzlage..."></textarea>
                                </div>

                                <div id="additionalParagraphs" class="form-group">
                                    <div>
                                        <label for="paragraph1">Absatz 1:</label>
                                        <textarea class="form-control" name="paragraphs[]"></textarea>
                                    </div>
                                </div>


                                <br>
                                <button type="button" class="btn btn-primary" onclick="addParagraph()">Absatz hinzufügen</button>


                                <div class="form-group mb-3">
                                    <label for="image">Einstzbild hochladen</label>
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

            <div class="card-body">
                <div class="scroll-container">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th>Author</th>
                            <th>Einsatznummer</th>
                            <th>Meldewort</th>
                            <th>Datum</th>
                            @if($isleitung)
                                <th>Optionen</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($berichte as $bericht)
                            <tr>
                                <td>{{$bericht->author}}</td>
                                <td>{{$bericht->einsatzNummer}}</td>
                                <td>{{$bericht->einsatzStichwort}}</td>
                                <td>{{$bericht->datum}}</td>
                                @if($isleitung)
                                <td>
                                    <form action="/dashboard/berichte/deleteBericht/{{$bericht->id}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            Löschen
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    document.querySelectorAll('.btn-fahrzeuge').forEach(button => {
        button.addEventListener('click', function() {
            if (this.classList.contains('btn-selected')) {
                this.classList.remove('btn-selected');
            } else {
                this.classList.add('btn-selected');
            }
        });
    });
    let paragraphCount = 1;

    function addParagraph() {
        paragraphCount++;

        const newParagraph = document.createElement("div");
        newParagraph.classList.add("form-group");

        newParagraph.innerHTML = `
    <label for="paragraph${paragraphCount}">Absatz ${paragraphCount}:</label>
    <textarea class="form-control" id="paragraph${paragraphCount}" name="paragraphs[]" rows="4" placeholder="Weitere Details hier..."></textarea>
  `;

        document.getElementById("additionalParagraphs").appendChild(newParagraph);
    }

</script>
<style>

    .options{
        display: flex;
        flex-flow: row;
        flex-wrap: nowrap;
        justify-content: flex-end;
        gap: 1rem;
    }
    .scroll-container {
        max-height: 300px;
        overflow-y: auto;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #ddd;
    }

    .card {
        margin-top: 20px;
    }

    .scroll-container {
        padding: 10px;
    }

    .btn-container button {
        width: auto;
        white-space: nowrap;
    }

</style>
