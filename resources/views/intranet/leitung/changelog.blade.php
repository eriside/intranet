@extends("intranet.intranet")

@section("title", "To-Do")

@section("content")
    @if($roles->contains('Changelog Senden'))
        <div class="container my-5">
            <h1 class="text-center mb-4">Changelog</h1>

        </div>
        <div class="d-flex justify-content-center align-items-center" >
            <form action="/intranet/changelog/new" class="w-75" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="titel" class="col-form-label">Titel:</label>
                    <input type="text" class="form-control" id="titel" name="titel">
                </div>
                @foreach(['allgemein' => 'Allgemein', 'dev' => 'Ehrenamt', 'fuhr' => 'Fuhrpark', 'fw' => 'PSNV', 'rd' => 'Rettungsdienst', 'personal' => 'Personal'] as $id => $label)
                    <div class="mb-3">
                        <label for="{{ $id }}" class="col-form-label">{{ $label }}:</label>

                        <div class="mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '**', '**')">Fett</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '*', '*')">Kursiv</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '__', '__')">Unterstrichen</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '~~', '~~')">Durchgestrichen</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '> ', '')">Zitat</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '`', '`')">Inline-Code</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '```', '\n```')">Codeblock</button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="formatText('{{ $id }}', '||', '||')">Spoiler</button>
                        </div>

                        <textarea class="form-control" id="{{ $id }}" name="{{ $id }}"></textarea>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-success" >Absenden</button>
            </form>

        </div>
        <div class="container my-5">
            <h2 class="text-center mb-4">Bisherige Changelog-Einträge</h2>
            @foreach($changelogs as $changelog)
                <div class="card">
                    <div class="card-body">
                        <h3 class="mb-4">{{$changelog->titel}}</h3>
                        @if($changelog->allgemein != null)
                            <h5>Allgemein:</h5>
                            <span>{{!! nl2br(e($changelog->allgemein)) !!}}</span>
                        @endif
                        @if($changelog->dev != null)
                            <h5>Ehrenamt:</h5>
                            <span>{{!! nl2br(e($changelog->dev)) !!}}</span>
                        @endif
                        @if($changelog->fuhr != null)
                            <h5>Fuhrpark:</h5>
                            <span>{{!! nl2br(e($changelog->fuhr)) !!}}</span>
                        @endif
                        @if($changelog->fw != null)
                            <h5>Feuerwehr:</h5>
                            <span>{{!! nl2br(e($changelog->fw)) !!}}</span>
                        @endif
                        @if($changelog->rd != null)
                            <h5>Rettungsdienst:</h5>
                            <span>{{!! nl2br(e($changelog->rd)) !!}}</span>
                        @endif
                        @if($changelog->personal != null)
                            <h5>Personal:</h5>
                            <span>{{!! nl2br(e($changelog->personal)) !!}}</span>
                        @endif
                    </div>
                </div>

            @endforeach
        </div>
    @else
        <h1 class="text-center mb-4">Keine Berechtigung</h1>
    @endif



    <script>
        function getCalendarWeek(date) {
            let target = new Date(date.valueOf());
            let dayNr = (date.getDay() + 6) % 7; // Montag = 0, Sonntag = 6
            target.setDate(target.getDate() - dayNr + 3);
            let firstThursday = target.valueOf();
            target.setMonth(0, 1);
            if (target.getDay() !== 4) {
                target.setMonth(0, 1 + ((4 - target.getDay()) + 7) % 7);
            }
            let weekNumber = 1 + Math.ceil((firstThursday - target) / 604800000);
            return weekNumber;
        }

        let today = new Date();
        document.getElementById("titel").value = "Changelog KW " + getCalendarWeek(today) + ": Was ist passiert?";


        function formatText(textareaId, prefix, suffix) {
            let textarea = document.getElementById(textareaId);
            let start = textarea.selectionStart;
            let end = textarea.selectionEnd;
            let selectedText = textarea.value.substring(start, end);

            // Falls nichts markiert ist, Cursor-Position setzen
            if (selectedText.length === 0) {
                textarea.setRangeText(prefix + suffix, start, start, "end");
                textarea.setSelectionRange(start + prefix.length, start + prefix.length);
            } else {
                textarea.setRangeText(prefix + selectedText + suffix, start, end, "end");
            }

            textarea.focus();
        }
    </script>
    <style>
    .card-body h5{
        font-weight: bold;
    }

    </style>
@endsection
