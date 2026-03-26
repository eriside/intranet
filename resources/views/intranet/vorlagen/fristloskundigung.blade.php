<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Beförderung</title>

    <style>
        @page {
            margin: 0;
        }

        table td:nth-child(2) {
            text-align: right;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            position: relative;
        }

        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: -1;
        }

        .content {
            padding-top: 100px;
            padding-left: 100px;
            padding-right: 100px;
        }

        h1, h2{
            text-align: center;
        }


        .center {
            text-align: center;
        }


        .signature {
            font-family: "Lucida Handwriting", cursive;
            font-size: 36px;
        }

    </style>
</head>
<body>

    <img src="{{ public_path('images/image1.png') }}" class="background" alt="Hintergrund">

    <div class="content">

        <div style="position: absolute; right: 120px; top: 160px; text-align: right">
            <p style="margin: -4px"><strong>Berufsfeuerwehr Rheinstadt</strong></p>
            <p style="margin: -4px"><strong>Melanoma Street,</strong></p>
            <p style="margin: -4px"><strong>8207 - 8208 Rheinstadt</strong></p>
        </div>
        <div style="position: absolute; left: 60px; top: 240px;">
            <p>Berufsfeuerwehr Rheinstadt | 8207 - 8208 Rheinstadt</p>
            <p style="font-size: 13px">{{$mitarbeiter}}</p>
            <p style="font-size: 13px; margin-top: -15px">Melanoma Street</p>
            <p style="font-size: 13px; margin-top: -15px">8207 - 8208 Rheinstadt</p>
        </div>

        <div style="position: absolute; right: 120px; top: 400px; text-align: right">
            <p style="font-size: 13px; margin: -4px">Rheinstadt, {{\Carbon\Carbon::now()->format('d.m.y')}}</p>
        </div>
        <div style="position: absolute; left: 60px; top: 420px; padding-right: 100px;">
            <p style="font-size: 18px"><strong>Fristlose Kündigung des Arbeitsverhältnisses</strong></p>
            <p style="font-size: 14px">Sehr
                @if($geschlecht == 'Männlich')
                    geehrter Herr {{$mitarbeiter}}
                @else
                    geehrte Frau {{$mitarbeiter}}
                @endif
            </p>
            <p style="font-size: 14px; margin-top: 40px">hiermit kündigen wir Ihnen das aktuell bestehende Arbeitsverhältnis vom {{$einstellung}} fristlos. Wir sehen uns zu diesem Schritt aufgrund von {{$grund}} gezwungen.</p>
            <p style="font-size: 14px; margin-top: 20px">Wir fordern Sie hiermit ebenfalls auf, all Ihre von uns gestellten Arbeitsmaterialien mit sofortiger Wirkung zurückzugeben. </p>
            <p style="font-size: 14px; margin-top: 20px">Gleichzeitig weisen wir darauf hin, dass wir in Ihrem Fall @if($law == 0) keine @endif rechtlichen Schritte einleiten werden.</p>
            <p style="font-size: 14px; margin-top: 80px">Mit freundlichen Grüßen</p>
            <p class="signature" style="margin-top: -10px">{{$verwalter}}</p>
            <p style="font-size: 12px; margin-top: -25px">{{$verwalter}}</p>
            <p style="font-size: 12px; margin-top: -15px">{{$rang}}</p>
        </div>








    </div>

</body>
</html>
