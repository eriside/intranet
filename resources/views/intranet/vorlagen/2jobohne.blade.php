<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zweitjob </title>
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
            padding-top: 40px;
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

<img src="{{ public_path('images/image1.png') }}" class="background" alt="Hintergrund">

<div class="content">
    <h1>Zusatzvereinbarung zum Arbeitsvertrag</h1>
    <div class="center">
        <p><strong>Zwischen</strong></p>
        <p><strong>Berufsfeuerwehr Rheinstadt</strong></p>
        <p>vertreten durch {{$verwalter}}</p>
        <p>(nachfolgend "Arbeitgeber" genannt)</p>
        <p><strong>und</strong></p>
        <p>{{$mitarbeiter}}</p>
        <p>(nachfolgend "Arbeitnehmer" genannt)</p>
        <p><strong>wird folgende Zusatzvereinbarung zum Arbeitsvertrag geschlossen: </strong></p>
    </div>
    <div>
        <p>1. Genehmigung für einen Nebenjob:</p>
        <p>Der Arbeitnehmer erhält hiermit nach sorgfältiger Prüfung die Genehmigung für einen zweiten Job.</p>
        <p>2. 70/30 Regel:</p>
        <p>Der Arbeitnehmer verpflichtet, seine Arbeitszeit zwischen der Berufsfeuerwehr und seiner Nebentätigkeit im Verhältnis von 70 % für die Berufsfeuerwehr und 30 % für die Nebentätigkeit aufzuteilen.</p>
        <p>3. Pflichten des Arbeitnehmers: </p>
        <p>a) Der Arbeitnehmer ist verantwortlich dafür, dass kein Interessenkonflikt zwischen der Berufsfeuerwehr und seinem Zweitjob entsteht. </p>
        <p>b) Der Arbeitnehmer verpflichtet sich, die 70/30 Regel zu halten.</p>
        <p>4. Widerrufsrecht:</p>
        <p>a) Der Arbeitgeber behält sich das Recht vor, die Genehmigung auf einen 2. Job zu widerrufen, wenn festgestellt wird, dass die Haupttätigkeit bei der Berufsfeuerwehr beeinträchtigt wird.</p>
        <p>b) Der Widerruf erfolgt schriftlich mit einer angemessenen Vorankündigungszeit, um dem Arbeitnehmer die Möglichkeit zu geben, seine Nebentätigkeit zu beenden. </p>
        <p>5. Dauer des Vertrags: </p>
        <p>Dieser Vertrag tritt mit der Unterzeichnung in Kraft und bleibt in Kraft, solange der Vertrag nicht widerrufen wird und der Arbeitnehmer seinen Pflichten nachkommt. </p>
    </div>





    <table style="width: 100%; padding-top: 150px">
        <tr>
            <td><div class="signature" style="color: white">{{$verwalter}}</div>
                <hr></td>
            <td><div class="signature" style="color: white" >{{$mitarbeiter}}</div>
                <hr></td>
        </tr>
        <tr><td>Berufsfeuerwehr Rheinstadt</td></tr>
        <tr>
            <td>{{$verwalter}}</td>
            <td>{{$mitarbeiter}}</td>
        </tr>
        <tr>
            <td>{{$position}}</td>

        </tr>
        <tr>
            <td>Rheinstadt der, {{\Illuminate\Support\Carbon::now()->format('d.m.y')}}</td>
            <td>Rheinstadt der, {{\Illuminate\Support\Carbon::now()->format('d.m.y')}}</td>
        </tr>
    </table>






</div>

</body>
</html>
