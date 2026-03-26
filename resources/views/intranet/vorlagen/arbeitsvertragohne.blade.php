<!DOCTYPE html>
<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Arbeitsvertrag</title>
    <style>
        /* Grundeinstellungen für "Word/Docs"-Look */
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Sieht aus wie Arial, unterstützt aber € und Umlaute */
            font-size: 11pt;
            line-height: 1.5; /* Angenehmer Leseabstand wie im Standard-Doc */
            color: #000000;
        }

        /* Seitenränder simulieren (Standard A4 Ränder) */
        @page {
            margin: 2.5cm 2.5cm 2.0cm 2.5cm; /* Oben, Rechts, Unten, Links */
        }

        /* Die Hauptüberschrift */
        .main-title {
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* Paragraphen-Titel (§ 1 ...) */
        .section-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            text-decoration: underline; /* Optional, wirkt vertraglicher */
        }

        /* Fließtext */
        p {
            margin-bottom: 10px;
            text-align: justify; /* Blocksatz für professionellen Look */
        }

        /* Einrückungen für Listen (falls nötig) */
        ul {
            margin-left: 15px;
            padding-left: 0;
        }

        /* Tabelle für die Vertragsparteien (sieht sauberer aus als reiner Text) */
        .parties-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .parties-table td {
            vertical-align: top;
            padding: 5px 0;
        }

        /* Unterschriften-Bereich (WICHTIG: Tabelle nutzen, damit es nebeneinander bleibt) */
        .signature-table {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid; /* Versucht, Unterschriften nicht zu zerreissen */
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .sign-line {
            border-top: 1px solid black;
            margin-top: 50px; /* Platz für die Unterschrift */
            margin-bottom: 5px;
            width: 90%;
        }
        
        .sign-label {
            font-size: 10pt;
        }

        /* Hilfsklasse für Fettgedrucktes */
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="main-title">ARBEITSVERTRAG</div>
    <div class="subtitle">(für Angestellte ohne Tarifbindung)</div>

    <br>

    <p>Zwischen</p>
    
    <table class="parties-table">
        <tr>
            <td width="25%"><strong>Arbeitgeber:</strong></td>
            <td>
                Musterfirma GmbH<br>
                Musterstraße 1<br>
                12345 Musterstadt
            </td>
        </tr>
        <tr>
            <td colspan="2" style="height: 10px;"></td> </tr>
        <tr>
            <td width="25%"><strong>Arbeitnehmer:</strong></td>
            <td>
                <strong>{{ $mitarbeiter }}</strong><br>
                Wohnhaft bekannt
            </td>
        </tr>
    </table>

    <p>wird folgender Arbeitsvertrag geschlossen:</p>

    <div class="section-title">§ 1 Beginn des Arbeitsverhältnisses / Tätigkeit</div>
    <p>
        Das Arbeitsverhältnis beginnt am <strong>{{ $einstellung }}</strong>. 
        Der Arbeitnehmer wird als <strong>{{ $rang }}</strong> ({{ $position }}) eingestellt.
    </p>
    <p>
        Die Probezeit beträgt 6 Monate. Während der Probezeit kann das Arbeitsverhältnis von beiden Seiten mit einer Frist von zwei Wochen gekündigt werden.
    </p>

    <div class="section-title">§ 2 Arbeitszeit</div>
    <p>
        Es wird eine Beschäftigung in <strong>{{ $arbeitsverhaltnis }}</strong> vereinbart. 
        Die Verteilung der Arbeitszeit richtet sich nach den betrieblichen Erfordernissen.
    </p>

    <div class="section-title">§ 3 Vergütung</div>
    <p>
        Der Arbeitnehmer erhält für seine Tätigkeit ein monatliches Bruttogehalt in Höhe von:
    </p>
    <p style="text-align: center; font-weight: bold; font-size: 12pt; margin: 20px 0;">
        {{ number_format($gehalt, 2, ',', '.') }} €
    </p>
    <p>
        Die Vergütung ist jeweils am Ende eines Kalendermonats fällig und wird auf das vom Arbeitnehmer benannte Konto überwiesen.
    </p>

    <div class="section-title">§ 4 Urlaub</div>
    <p>
        Der Arbeitnehmer hat Anspruch auf den gesetzlichen Mindesturlaub von derzeit 20 Arbeitstagen (bei einer 5-Tage-Woche). 
        Zusätzlich gewährt der Arbeitgeber einen vertraglichen Zusatzurlaub.
    </p>

    <div class="section-title">§ 5 Sonstige Pflichten</div>
    <p>
        Der Arbeitnehmer verpflichtet sich, über alle betrieblichen Angelegenheiten, die ihm im Rahmen seiner Tätigkeit bekannt werden, Stillschweigen zu bewahren.
    </p>

    <br><br>

    <p>Ort, Datum: ________________, den {{ $datum2 }}</p>

    <table class="signature-table">
        <tr>
            <td>
                <div class="sign-line"></div>
                <div class="sign-label">
                    <strong>{{ $verwalter }}</strong><br>
                    (Für den Arbeitgeber)
                </div>
            </td>

            <td>
                <div class="sign-line"></div>
                <div class="sign-label">
                    <strong>{{ $mitarbeiter }}</strong><br>
                    (Arbeitnehmer)
                </div>
            </td>
        </tr>
    </table>

</body>
</html>