<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Personalerfassungsbogen </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        @page {
            margin: 0;
        }

        table td:nth-child(2) {
            text-align: right;
        }

        body {
            margin: 0;
            font-family: DejaVu Sans, sans-serif;
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

        p, li {
            margin-bottom: 10px;
        }

        .center {
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 20px;
        }
        .signature {
            font-family: "Lucida Handwriting", cursive;
            font-size: 36px;
        }
        .options{
            display: flex;
            flex-flow: row;
            flex-wrap: nowrap;
            justify-content: flex-end;
            gap: 1rem;
        }
    </style>
</head>
<body>

<img class="background" src="{{ public_path('images/Kopie von Personalerfassungsbogen_Ehrenamt-1.png') }}" alt="Hintergrund">

<div class="content">
    <p style="position:absolute; left: 250px; top: 152px; font-size: 15px">{{$name}}</p>
    <p style="position:absolute; left: 560px; top: 152px; font-size: 15px">{{$datum}}</p>
    <p style="position:absolute; left: 250px; top: 190px; font-size: 15px">{{$vorname}}</p>
    <p style="position:absolute; left: 560px; top: 190px; font-size: 15px">{{$geschlecht}}</p>
    <p style="position:absolute; left: 250px; top: 225px; font-size: 15px">{{$email}}</p>
    <p style="position:absolute; left: 250px; top: 260px; font-size: 15px">{{$nummer}}</p>
    <p style="position:absolute; left: 250px; top: 295px; font-size: 15px">{{$iban}}</p>
    <p style="position:absolute; left: 560px; top: 295px; font-size: 15px">{{$führerscheinklassen}}</p>

    <center>
        <p style="font-size: 15px; position:relative; top: 600px">{{$arbeitgeber}}</p>
    </center>
    <p style="position:absolute; font-size: 15px; top: 940px">{{\Carbon\Carbon::now()->format('d.m.Y')}} {{$vorname}} {{$name}}</p>
    <p style="position:absolute; font-size: 15px; top: 940px; left: 500px">{{$verwalter}}</p>
    <p style="position:absolute; font-size: 12px; top: 970px; left: 500px">{{$verwalter}}</p>
    <p style="position:absolute; font-size: 12px; top: 1056px; left: 615px; color: #ff4023">{{\Carbon\Carbon::now()->format('d.m.Y')}}</p>


</div>

</body>
</html>
