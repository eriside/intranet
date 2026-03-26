@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('Kats'))
        <div class="container my-5">
            <h1 class="text-center text-white mb-4">Mitarbeiter</h1>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <input type="text" id="searchInput" class="form-control text-white bg-dark border-secondary" placeholder="Suchen..."
                       style="width: 300px; height: 3rem;" onkeyup="searchCards()" />
                <a href="{{url('/intranet/kats/mitarbeiter/new')}}" class="btn btn-success" >Neuer Mitarbeiter</a>
            </div>
        </div>

        <div class="row mt-4 d-flex justify-content-center align-items-stretch">
            @foreach($mitarbeiter as $mitarbeiter)
                    @if( $mitarbeiter->aktiv)
                        <div class="col-11 col-md-4 col-lg-3 mx-2 mb-4" data-title="{{$mitarbeiter->name}} {{$mitarbeiter->vorname}} ">
                            <div class="card h-100 shadow" style="background-color: #2e3338; border: none; border-radius: 15px;">
                                <div class="card-body text-white">
                                    <h5 class="card-title fw-bold">{{$mitarbeiter->name}} {{$mitarbeiter->vorname}}</h5>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{url('/intranet/kats/mitarbeiter/view', $mitarbeiter->id)}}" class="btn btn-primary btn-sm rounded-pill">
                                            Ansehen
                                        </a>
                                        <a href="{{url('/intranet/kats/mitarbeiter/edit', $mitarbeiter->id)}}" class="btn btn-danger btn-sm rounded-pill">
                                            Bearbeiten
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            @endforeach
        </div>
    @else
        <h1 class="text-center text-danger my-5">Keine Berechtigung</h1>
    @endif

    <script>
        function searchCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const cards = document.querySelectorAll('[data-title]');

            cards.forEach(card => {
                const title = card.getAttribute('data-title').toLowerCase();
                card.style.display = title.includes(searchInput) ? '' : 'none';
            });
        }
    </script>

    <style>
        body {
            background-color: #1f1f1f;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .card:hover {
            transform: translateY(-2px);
            transition: 0.2s ease-in-out;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
@endsection
