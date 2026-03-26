@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('To Do'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Leitungs To-Do Liste</h1>
            <div class="card mx-auto">
                <div class="card-body">
                    <form action="/intranet/todo/new" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="description" placeholder="Neue Aufgabe hinzufügen" required>
                            <button class="btn btn-success" type="submit">Hinzufügen</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>

            <div id="todo-list">
                @foreach($todos as $todo)
                    <div class="card shadow-sm rounded mb-2 mx-auto todo-item" data-id="{{$todo->id}}">
                        <div class="card-body py-2 px-3">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                <tr>
                                    @if($todo->status == 'offen')
                                        <td class="rotes-quadrat" style="color: red">&#x25A0;</td>
                                    @elseif($todo->status == 'In Arbeit')
                                        <td class="gelb-quadrat" style="color: orange">&#x25A0;</td>
                                    @elseif($todo->status == 'Erledigt')
                                        <td class="green-quadrat" style="color: green">&#x25A0;</td>
                                    @endif
                                    <td style="vertical-align: middle !important; text-align: left !important; width: 0px"><span class="text-start" style="display: inline-block;">{{$todo->position}}.</span></td>
                                    <td style="vertical-align: middle !important; text-align: left !important;"><span class="text-start" style="display: inline-block;">{{$todo->description}}</span></td>

                                    <td class="options">
                                        <form id="todo-form-{{$todo->id}}" action="/intranet/todo/update/{{$todo->id}}" method="POST">
                                            @csrf
                                            <select class="form-control form-control-sm status-dropdown" name="status" data-id="{{$todo->id}}" required>
                                                <option value="offen" {{ $todo->status == 'offen' ? 'selected' : '' }}>Offen</option>
                                                <option value="In Arbeit" {{ $todo->status == 'In Arbeit' ? 'selected' : '' }}>In Arbeit</option>
                                                <option value="Erledigt" {{ $todo->status == 'Erledigt' ? 'selected' : '' }}>Erledigt</option>
                                            </select>
                                        </form>
                                        <form method="post" action="/intranet/todo/delete/{{$todo->id}}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Löschen</button>
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                document.getElementById('todo-form-' + this.dataset.id).submit();
            });
        });

        let todoList = document.getElementById('todo-list');
        new Sortable(todoList, {
            animation: 150,
            onEnd: function (evt) {
                let order = [];
                document.querySelectorAll('.todo-item').forEach((item, index) => {
                    order.push({ id: item.dataset.id, position: index + 1 });
                });

                fetch('/intranet/todo/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                });
                location.reload();
            }
        });
    </script>

    <style>
        .card {
            padding: 5px !important;
            margin-bottom: 5px;
            width: 60%;
            cursor: grab;
        }

        .card-body {
            padding: 5px;
        }

        .table {
            margin-bottom: 0;
        }


        .rotes-quadrat, .gelb-quadrat, .green-quadrat {
            font-size: 1.5rem;
            line-height: 1;
            padding-right: 10px;
            width: 30px;
        }

        .options {
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 1rem;
        }




    </style>
@endsection
