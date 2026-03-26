<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Aufhebungsvertrag </title>
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
        h3 {
            font-size: 20px;
        }
        p, li {
            margin-bottom: 10px;
            font-size: 13px;
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
    <h1>Aufhebungsvertrag</h1>
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
        <h3>§ 1 Beendigung des Arbeitsverhältnisses </h3>
        <p>Die Parteien haben hiermit das zwischen ihnen bestehende Arbeitsverhältnis zur Vermeidung einer ansonsten
            unausweichlichen, vom Arbeitgeber auszusprechenden ordentlichen Kündigung aus freiwillige Gründen
            einvernehmlich zum 07.05.2025 auf.
            Mit diesem Austrittsdatum ist die im Falle einer Kündigung durch den Arbeitgeber
            einzuhaltende ordentliche Kündigungsfrist gewahrt.</p>
        <h3>§ 2 Abfindung
        </h3>
        <p>Da der Vertrag im Einvernehmen beider Seiten aufgelöst wird und beide Seiten auf jegliches
            Recht verzichten, entsteht auch kein Anspruch auf Abfindung. </p>
        <h3>§ 3 Zeugnis
        </h3>
        <p>Ein Anspruch auf ein Arbeitszeugnis wird dem Arbeitnehmer nicht verwehrt und er hat auch
            nach Abschluss dieses Aufhebungsvertrages weiter ein Anrecht unter Einbehaltung von
            § 22 des Arbeitsrechts darauf.</p>

        <h3>§ 4 Freistellung</h3>
        <p>Der Arbeitgeber und Arbeitnehmer verzichten auf eine Freistellung, da der Arbeitsvertrag mit
            sofortiger Wirkung aufgehoben wird. </p>
        <h3>§ 5 Gehaltsansprüche </h3>
        <p>Der Arbeitgeber zahlt an den Arbeitnehmer bis zur Beendigung des Arbeitsverhältnisses das
            ihm zustehende reguläre Gehalt in Höhe seines Paychecks in Stunden.</p>
        <h3 style="padding-top: 150px">§ 6 Rückgabe von Firmeneigentum </h3>
        <p>Der Arbeitnehmer händigt zum sofortigen Zeitpunkt dem Arbeitgeber gehörende
            Sachen an ihn aus.
            Darüber hinausgehende, zum Betrieb gehörende Sachen befinden sich nicht im Besitz des
            Arbeitnehmers. </p>
        <h3>§ 7 Ausgleichsklausel </h3>
        <p>Mit der Erfüllung der in dieser Vereinbarung niedergelegten Pflichten sind sämtliche
            gegenseitigen Ansprüche aus dem Arbeitsverhältnis und aus seiner Beendigung, gleich aus
            welchem Rechtsgrund, erfüllt. </p>
        <h3>§ 8 Schlussbestimmungen
        </h3>
        <p>Der vorliegende Vertrag wurde zweifach ausgefertigt und von beiden Parteien
            unterschrieben. Dem Arbeitnehmer wurde eine Ausfertigung dieses Vertrags ausgehändigt.</p>
    </div>





    <table style="width: 100%; padding-top: 400px">
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
