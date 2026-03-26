<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Zusatzvertrag – {{ $mitarbeiter }}</title>
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

<img src="{{ public_path('images/image1.png') }}" class="background" alt="Hintergrund">

<div class="content">
    <h1>Zusatzvertrag Notarzt </h1>
    <p><strong>Präambel:</strong> Dieser Vertrag gilt nur für RP-Zwecke auf dem FiveM-RP-Server Gaminglife. Er findet sonst keine Anwendung.</p>
    <div class="center">
        <p><strong>Zwischen</strong></p>
        <p><strong>Berufsfeuerwehr Rheinstadt</strong></p>
        <p>vertreten durch {{$verwalter}}</p>
        <p>(nachfolgend "Arbeitgeber" genannt)</p>
        <br>
        <p><strong>und</strong></p>
        <p>{{$mitarbeiter}}</p>
        <p>(nachfolgend "Arbeitnehmer" genannt)</p>
        <p><strong>wird folgender Arbeitsvertrag geschlossen: </strong></p>

    </div>

    <h3>§1 Gegenstand des Vertrages</h3>
    <p>Gegenstand dieses Vertrages ist die Begrenzung der beruflichen Tätigkeit. Es ist Notärzten der Berufsfeuerwehr Rheinstadt verboten, eine medizinische Nebentätigkeit auszuüben. </p>

    <h3>§2 Vertragsdauer</h3>
    <p>1. Der Vertrag wird auf unbefristete Dauer geschlossen. </p>
    <p>2. Der Arbeitgeber behält sich vor, vor Inkrafttreten dieses Vertrages, dem Arbeitnehmer eine befristete Probezeit aufzuerlegen. </p>

    <h3>§3 Institutionen</h3>
    <p>Unter medizinische Berufe fallen Tätigkeiten in folgenden oder ähnlichen Unternehmen:</p>
    <p>1. Polizei (Einsatzssanitäter und Ärzte)</p>
    <p>2. Justiz (medizinische Abteilung)</p>
    <p>3. Rheinstädtisches Klinikum</p>
    <p>4. Sonstige mit der Medizin nahe oder verwandte Institutionen</p>

    <h3>§4 Beendigung des Nutzungsvertrags</h3>
    <p>1. Mit der Beendigung des Arbeitsverhältnisses mit der Berufsfeuerwehr Rheinstadt wird auch dieser Vertrag beendet. </p>
    <p>2. Dieser Vertrag kann seitens beider Parteien mündlich als auch schriftlich gekündigt werden. </p>

    <h3 style="padding-top: 90px">§5 Sonstige Bestimmungen</h3>
    <p>1. Änderungen und Ergänzungen dieses Vertrags bedürfen der Schriftform. </p>
    <p>2. Sollte eine Bestimmung dieses Vertrages unwirksam sein oder werden oder sollte sich eine Regelungslücke zeigen, so berührt dies nicht die Wirksamkeit der übrigen Bestimmungen dieses Vertrages. Die Parteien verpflichten sich, die etwa unwirksame Bestimmung durch eine Bestimmung zu ersetzen, die dem rechtlichen und wirtschaftlichen Regelungsgehalt der etwa unwirksamen Bestimmung am nächsten kommt. In gleicher Weise werden die Parteien eine etwa auftretende Regelungslücke schließen. </p>




    <table style="width: 100%; padding-top: 300px">
        <tr>
            <td><div class="signature">{{$verwalter}}</div>
                <hr></td>
            <td><div class="signature" >{{$mitarbeiter}}</div>
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
            <td>Rheinstadt der, {{$datum2}}</td>
            <td>Rheinstadt der, {{$datum2}}</td>
        </tr>
    </table>






</div>

</body>
</html>
