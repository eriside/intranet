<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Arbeitsvertrag – {{ $mitarbeiter }}</title>
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
    <h1>Arbeitsvertrag</h1>
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
    <p>Gegenstand dieses Vertrages ist ein unbefristetes Arbeitsverhältnis mit Tarifbindung, das je nach einvernehmlicher Vereinbarung in {{$arbeitsverhaltnis}} ausgeübt wird.</p>

    <h3>§2 Beginn des Arbeitsverhältnisses</h3>
    <p>Das Arbeitsverhältnis beginnt am {{$einstellung}}. Es wird auf unbestimmte Zeit geschlossen.</p>

    <h3>§3 Anwendbarkeit tariflicher Regelungen</h3>
    <p>(1) Für das Arbeitsverhältnis gelten die Regelungen des staatlichen Tarifvertrages in seiner jeweils gültigen Fassung (nachfolgend „Tarifvertrag“):</p>
    <p>-Staatliches Gehalt</p>
    <p>(2)  Falls die Regelungen dieses Arbeitsvertrages dem Inhalt des Tarifvertrages widersprechen, gilt
        vorrangig der Tarifvertrag, es sei denn abweichende einzelvertragliche Regelungen sind durch den
        Tarifvertrag gestattet oder es wird von den tarifvertraglichen Regelungen zugunsten des Arbeitnehmers
        abgewichen.</p>

    <h3>§4 Betriebsvereinbarungen</h3>
    <p>(1) Auf das Arbeitsverhältnis finden keine Betriebsvereinbarungen Anwendung.</p>
    <p>(2) Falls im Betrieb des Arbeitgebers zukünftig betriebliche Regelungen – Betriebsvereinbarungen,
        Richtlinien und Regelungen – gelten, gehen Sie den Regelungen dieses Arbeitsvertrages vor. Dies gilt
        jedoch nicht, soweit die einzelvertraglichen Regelungen für den Arbeitnehmer günstiger sind. </p>

    <h3 style="padding-top: 90px">§5 Probezeit
    </h3>
    <p>(1) Die ersten 14 Tage des Arbeitsverhältnisses gelten als Probezeit. </p>
    <p>(2) Während der Probezeit kann das Arbeitsverhältnis von jeder Vertragspartei ohne Angabe von Gründen gekündigt werden. </p>

    <h3>§6 Tätigkeit
    </h3>
    <p>(1) Der Arbeitnehmer wird als {{$rang}} angestellt. Der Dienstgrad kann mit steigender
        Qualifikation ändern.</p>
    <p>(2) Der Arbeitsort ist an der Feuer- und Rettungswache Süd. Der Arbeitnehmer kann den Arbeitsort
        nicht frei wählen und ist an die Arbeitsortszuweisung der Leitstelle gebunden. </p>
    <p>(3) Im Rahmen der Ausübung ihres/seines Berufes ist es dem Arbeitnehmer erlaubt, auch außerhalb der
        oben genannten Ortschaft seiner/ihrer Tätigkeit nachzugehen. </p>
    <p>(4) Der Arbeitnehmer verpflichtet sich, seine volle Arbeitskraft in den Dienst des Arbeitgebers zu stellen.
    </p>
    <p>(5) Der Arbeitgeber ist unter angemessener Berücksichtigung der Belange des Arbeitnehmers
        berechtigt, dem Arbeitnehmer andere oder zusätzliche, seiner Vorbildung und Qualifikation
        entsprechende, zumutbare Aufgaben anzuvertrauen. Darüber hinaus ist der Arbeitgeber berechtigt,
        dem Arbeitnehmer bei gleichbleibender Vergütung geringere Aufgaben innerhalb des Unternehmens
        zuzuweisen. </p>
    <h3>§7 Wechsel der Tätigkeit und des Arbeitsortes </h3>
    <p>Soweit betrieblich erforderlich, ist der Arbeitgeber unter angemessener Berücksichtigung der Belange
        des Arbeitnehmers berechtigt, dem Arbeitnehmer vorübergehend oder auf Dauer eine andere oder
        zusätzliche zumutbare und gleichwertige Tätigkeit im Unternehmen, auch an einem anderen Arbeitsort
        oder zu anderen Arbeitszeiten zuzuweisen. </p>
    <h3>§8 Arbeitszeit, Ruhepausen, Überstunden, Kurzarbeit, Abwesenheit
    </h3>
    <p>(1) Die wöchentliche Mindestdienstzeit wird betrieblich nicht vorgeschrieben. Sie sollte jedoch einen
        wirtschaftlichen Sinn für das Unternehmen haben. </p>
    <p>(2) Der Anspruch des Arbeitnehmers auf Ruhepausen und Ruhezeiten richtet sich nach dem
        Gesetz. Pausen gelten nicht als Arbeitszeit, jedoch als Dienstzeit. </p>
    (3) Der Arbeitnehmer ist verpflichtet, bei betrieblichen Bedürfnissen im Rahmen der gesetzlichen
    Höchstgrenzen Mehrarbeit, Überstunden, Nacht-, Sonntags- und Feiertagsarbeit zu leisten. </p>
    <p>(4) Die Beurteilung der Wirtschaftlichkeit eines Mitarbeiters obliegt der Verwaltungsabteilung (HR).
    </p>
    <p>(5) Das Modell der Kurzarbeit wird durch den Arbeitgeber nicht angeboten.
    </p>
    <p>(6) Der Arbeitnehmer verpflichtet sich, einen Ausfall der länger als drei Tage andauert, beim
        Arbeitgeberanzugeigen. Die maximale Dauer der Abwesenheit beträgt vier Wochen. </p>
    <h3 style="padding-top: 120px">§9 Vergütung</h3>
    <p>Soweit tarifvertraglich nichts anderes bestimmt ist, gilt Folgendes: </p>
    <p>(1) Der Arbeitnehmer erhält für die ihm übertragenen Tätigkeiten ein Nettoarbeitsentgelt in Höhe von
        {{$gehalt}},00 € pro Stunde. </p>
    <p>(2) Das Arbeitsentgelt für einen Kalendermonat ist alle 45 Minuten fällig und wird vom Arbeitgeber bis
        zu diesem Datum auf, das in der Personalakte bezeichnete Bankkonto des Arbeitnehmers
        überwiesen. </p>
    <p>(3) Der Arbeitnehmer verpflichtet sich, zu viel erhaltene Vergütung zurückzuzahlen. Er wird sich nicht
        auf den Wegfall der Bereicherung berufen, wenn die rechtsgrundlose Überzahlung so offensichtlich
        war, dass der Arbeitgeber dies hätte erkennen müssen, oder wenn die Überzahlung auf Umständen
        beruhte, die der Arbeitgeber zu vertreten hat. </p>
    <h3>§10 Sonderzuwendungen </h3>
    <p>Die Parteien treffen keine Sonderzuwendungsvereinbarungen.
    </p>
    <h3>§11 Fortbildungen
    </h3>
    <p>(1) Jeder Arbeitnehmer hat das Recht, Fortbildungen zu erhalten. Diese werden im Rahmen der
        Weiterbildung durch den Arbeitgeber angeboten.</p>
    <p>(2) Für die Dauer der Fortbildung wird der Arbeitnehmer unter der Fortzahlung des Lohns von der
        Arbeit freigestellt. </p>
    <p>(3) Die gesamten Fortbildungskosten werden durch den Dienstherrn bezahlt, hier ist §28 dieses
        Arbeitsvertrags zu beachten. </p>
    <p>(4) Der Arbeitnehmer verpflichtet sich, mindestens 30 Minuten vor Ausbildungs- oder
        Fortbildungsbeginn das Fehlen schriftlich mitzuteilen, sofern er zugesagt hat. </p>
    <h3>§12 Dienstwagen </h3>
    <p>Der Arbeitgeber stellt dem Arbeitnehmer für die Dauer des Arbeitsverhältnisses den Dienstwagen zur
        Verfügung. Für die Nutzung des Dienstwagens gilt folgende Dienstwagenvereinbarung: </p>
    <p>-Dienstvorschrift </p>
    <h3 >§13 Vergütungsfortzahlung bei persönlicher Verhinderung </h3>
    <p>Soweit tarifvertraglich nichts anderes bestimmt ist, gilt Folgendes: </p>
    <p>(1) Die Vergütung wird nur für tatsächlich geleistete Arbeit gezahlt. Eine Vergütungsfortzahlung erfolgt
        jedoch bei persönlicher Verhinderung des Arbeitnehmers an der Arbeitsleistung in folgenden,
        abschließend geregelten Ausnahmefällen: </p>
    <p style="padding-top: 120px">a) Eheschließung des Arbeitnehmers; </p>
    <p>b) Entbindung der Ehefrau, Lebenspartnerin oder Lebensgefährtin des Arbeitnehmers in
        häuslicher Gemeinschaft; </p>
    <p>c) Ausfallende Arbeitszeit – ambulante Behandlung wegen eines während der Arbeitszeit
        erlittenen Arbeitsunfalls; </p>
    <p>d) Ausfallende Arbeitszeit – Arztbesuch wegen akuter Erkrankung, sofern nachweislich eine
        Verlegung außerhalb der Arbeitszeit nicht möglich ist.</p>
    <p>(2) Die Entgeltfortzahlung wird nur weitergeführt, wenn der Arbeitnehmer in den Dienst eingestempelt
        ist. </p>
    <h3>§14 Angaben zur Person </h3>
    <p>(1) Der Arbeitnehmer erklärt, dass er arbeitsfähig ist und an keiner ansteckenden Krankheit leidet,
        durch die insbesondere Mitarbeiter oder gegebenenfalls Bürger gefährdet werden könnten. Auch
        bestehen keine Krankheiten beziehungsweise gesundheitlichen Beeinträchtigungen, Alkohol- oder
        Drogensüchte, durch die die Eignung für die vorgesehene Tätigkeit auf Dauer oder in periodisch
        wiederkehrenden Abständen eingeschränkt ist. </p>
    <p>(2) Sonstige Umstände, die der Arbeitsaufnahme oder der Tätigkeit des Arbeitnehmers in absehbarer
        Zeit entgegenstehen (Operation, Kur usw.) oder sie wesentlich erschweren, liegen nicht vor. </p>
    <p>(3) Der Arbeitnehmer bestätigt, dass keine Vorstrafe im Zusammenhang mit seiner beruflichen
        Tätigkeitausgesprochen ist. Vorstrafen, die nach dem gängigen Procedere der Resozialisierung
        getilgt wurden oder zu tilgen sind, sind von dieser Bestätigung ausgenommen. </p>
    <p>(4) Der Arbeitnehmer erklärt, dass er im Besitz einer zur Arbeitsaufnahme gegebenenfalls
        erforderlichen Aufenthalts- und Arbeitserlaubnis ist. </p>
    <h3>§15 Verhalten am Arbeitsplatz </h3>
    <p>Soweit tarifvertraglich nichts anderes bestimmt ist, gilt Folgendes: </p>
    <p>(1) Der Arbeitnehmer hat am Arbeitsplatz stets den Weisungen des Arbeitgebers nachzukommen und
        den betrieblichen Verhaltensregeln zu folgen. Hierfür sind die Weisungen den Dienstvorschriften zu
        entnehmen. </p>
    <p>(2) Der Arbeitnehmer hat sich nach der betriebsinternen Kleiderordnung zu richten.
    </p>
    <p>(3) Gespräche mit Vertretern der Presse oder presseähnlicher Einrichtungen und öffentliche Auftritte,
        die im Zusammenhang mit der Tätigkeit stehen, bedürfen der vorherigen Zustimmung des
        Arbeitgebers. </p>
    <h3>§16 Verschwiegenheitspflicht
    </h3>
    <p>(1) Der Arbeitnehmer verpflichtet sich, während der Dauer des Arbeitsverhältnisses und auch nach dem
        Ausscheiden aus dem Arbeitsverhältnis, über alle Betriebs- und Geschäftsgeheimnisse Stillschweigen
        zu bewahren. </p>
    <p style="padding-top: 100px">(2) Für jeden Fall der Zuwiderhandlung gegen diese Pflicht verpflichtet der Arbeitnehmer sich, eine
        Vertragsstrafe in Höhe einer Bruttomonatsvergütung zu zahlen. Die Geltendmachung eines weiteren
        Schadens bleibt dem Arbeitgeber vorbehalten. </p>
    <p>(3) Die Kenntnis von Geschäftsgeheimnissen darf vom Arbeitnehmer in keinster Weise zur Förderung
        des eigenen oder fremden Wettbewerbs, aus Eigennutz, zugunsten eines Dritten oder in der Absicht,
        dem Arbeitgeber zu schaden, genutzt werden. Ein Verstoß wird nach §27 Abs. 4 GewO geahndet. </p>

    <p>(4) Verstößt der Arbeitnehmer gegen seine Verschwiegenheitspflicht, kann dies zur Kündigung führen.
    </p>
    <h3>§17 Wettbewerbsverbot
    </h3>
    <p>Dem Arbeitnehmer ist es untersagt, sich vor der rechtlichen Beendigung des Arbeitsverhältnisses
        selbstständig oder für fremde Rechnung in Konkurrenz zum Arbeitgeber zu betätigen. Ausgeschlossen
        von dieser Regelung sind der Rettungsdienst Rheinstadt, das Uniklinikum Rheinstadt und sonstige
        staatliche Institutionen. </p>
    <h3>§18 Datenschutz und Datensicherheit
    </h3>
    <p>(1) Mit dem Unterschreiben dieses Arbeitsvertrags stimmt der Arbeitnehmer voll und ganz den
        Datenschutzbestimmungen und der Datensicherheit zu. </p>
    <p>1. Patientendaten oder Informationen dürfen nur nach dem Vorliegen einer schriftlichen
        Zustimmung des Patienten beim Ärztlichen Leiter Rettungsdienst weitergegeben werden. </p>
    <p>2. An Passanten werden keine Auskünfte über Einsätze gegeben.</p>
    <p>3. Auch nach dem Ausscheiden aus der Berufsfeuerwehr dürfen keine Informationen nach
        außen getragen werden. </p>
    <p>4. Die Veröffentlichung interner Dokumente ist verboten. </p>
    <p>(2) Es dürfen nur im Falle von Straftaten Informationen über Patienten (Verletzungsbild) an die
        Behörden gegeben werden.</p>

    <p>(3) Die Weitergabe von Patientendaten an anderes an der Behandlung beteiligte Personal ist zulässig.
        Ebenso ist die Weitergabe von Informationen zum Einsatz an andere beteiligte Einsatzkräfte
        grundsätzlich gestattet. Ausnahmen können durch den Einsatzleiter der Berufsfeuerwehr definiert
        werden.</p>
    <p>(4) Jeglicher Verstoß gegen Datenschutz und Datensicherheit wird mit disziplinarischen
        Maßnahmengeahndet.</p>
    <h3>§19 Nebentätigkeit
    </h3>
    <p>(1)  Entgeltliche Nebenbeschäftigungen hat der Arbeitnehmer dem Arbeitgeber frühzeitig anzuzeigen.
        Es bedarf hierfür einer Genehmigung des Arbeitgebers. </p>
    <p>(2) Eine unentgeltliche Nebentätigkeit bedarf ebenfalls der Zustimmung des Arbeitgebers. Die
        Zustimmung darf nur aus sachlichen Gründen verweigert werden.</p>
    <p>(3) Ehrenamtliche Tätigkeiten sind meldepflichtig, jedoch nicht genehmigungspflichtig. </p>
    <h3 style="padding-top: 100px">§20 Anzeige- und Feststellungs- bzw. Nachweispflichten bei Krankheiten
    </h3>
    <p>Der Arbeitnehmer ist verpflichtet, dem Arbeitgeber jede Arbeitsunfähigkeit und deren voraussichtliche
        Dauer unverzüglich anzuzeigen. Eine erneute Anzeigepflicht besteht in allen Fällen einer
        Fortsetzungserkrankung oder einer erneuten Krankschreibung. </p>
    <h3>§21 Kündigung
    </h3>
    <p>(1) Innerhalb der Probezeit kann das Arbeitsverhältnis von jeder Vertragspartei gemäß den
        Bestimmungen des §5 dieses Arbeitsvertrages schriftlich gekündigt werden. Dies kann ohne Angabe
        von Gründen passieren. </p>
    <p>(2) Nach Ablauf der Probezeit kann das Arbeitsverhältnis von jeder Vertragspartei ordentlich gekündigt
        werden. Die Kündigungsfrist für beide Parteien richtet sich nach den jeweils geltenden
        Bestimmungen. Auch im Übrigen gelten für ordentliche Kündigungen die tarifvertraglichen
        Bestimmungen. Das Recht zur außerordentlichen Kündigung bleibt unberührt. Alle Kündigungen
        bedürfen der Schriftform. </p>
    <h3>§22 Kündigungsschutzklage
    </h3>
    <p>(1) Soweit der Arbeitnehmer geltend machen will, dass eine Kündigung sozial ungerechtfertigt oder
        ausanderen Gründen rechtsunwirksam ist, so muss er innerhalb von zwei Wochen nach Zugang der
        schriftlichen Kündigung Klage bei der Justiz Rheinstadt erheben, dass das Arbeitsverhältnis durch
        die Kündigung nicht aufgelöst ist. </p>
    <p>(2) Wird die Rechtsunwirksamkeit einer Kündigung nicht rechtzeitig geltend gemacht, ist die Kündigung
        als von Anfang an rechtswirksam anzusehen. Dies gilt auch bei einem nicht ordnungsgemäßen
        Nachweis der Einhaltung der Frist zur Erhebung einer Kündigungsschutzklage. </p>
    <h3>§23 Änderungen und Ergänzungen
    </h3>
    <p>(1) Änderungen und Ergänzungen dieses Arbeitsvertrages bedürfen zu ihrer Wirksamkeit der
        Schriftform und Unterzeichnung beider Parteien, dies gilt auch für die Aufhebung dieses
        Schriftformerfordernisses. Ausdrückliche und individuell ausgehandelte Absprachen bezüglich
        geänderter Vertragsinhalte sind jedoch vom Schriftformerfordernis nicht erfasst und sind wirksam,
        auch wenn sie mündlich getroffen wurden. </p>
    <p>(2) Der Arbeitnehmer verpflichtet sich, dem Arbeitgeber unverzüglich über Veränderungen der
        persönlichen Verhältnisse wie Namensänderungen zu informieren. </p>
    <h3>§24 Salvatorische Klausel
    </h3>
    <p>Sollte eine Bestimmung dieses Vertrages unwirksam sein oder werden oder sollte sich eine
        Regelungslücke zeigen, so berührt dies nicht die Wirksamkeit der übrigen Bestimmungen dieses
        Vertrages. Die Parteien verpflichten sich, die etwa unwirksame Bestimmung durch eine Bestimmung zu
        ersetzen, die dem rechtlichen und wirtschaftlichen Regelungsgehalt der etwa unwirksamen Bestimmung
        am nächsten kommt. In gleicher Weise werden die Parteien eine etwa auftretende Regelungslücke
        schließen. </p>
    <h3 style="padding-top: 100px">§25 Dienstkleidung
    </h3>
    <p>Im Dienst ist die vom Arbeitgeber vorgegebene Dienstkleidung zu tragen.
    </p>
    <h3>§26 Verhalten in Sozialen Medien
    </h3>
    <p>(1) Es dürfen keine Fotos von Einsätzen und/oder Patienten auf den Sozialen Medien hochgeladen
        werden.</p>
    <p>(2) Es dürfen keine menschenverachtenden Bilder oder Aussagen veröffentlicht werden.
    </p>
    <p>(3) Der Arbeitgeber kann Ausnahmen zu Abs. 1 genehmigen.
    </p>
    <h3>§27 Einhaltung von Gesundheits- und Sicherheitsvorschriften
    </h3>
    <p>(1) Der Arbeitnehmer verpflichtet sich, sämtliche Gesundheits- und Sicherheitsvorschriften, die für
        seine Tätigkeit als Einsatzkraft gelten, strikt einzuhalten. Dazu gehören unter anderem: </p>
    <p>1. Das Tragen der vorgeschriebenen Schutzausrüstung gemäß den behördlichen Richtlinien
        während sämtlicher dienstlicher Aktivitäten. </p>
    <p>2. Die regelmäßige Teilnahme an Schulungen und Fortbildungen zu sicherheitsrelevanten
        Themen und Notfallmaßnahmen. </p>
    <p>3. Die Beachtung und Umsetzung der Richtlinien für den Einsatz von Feuerlöschmitteln und
        Rettungsgeräten gemäß den geltenden Vorschriften.</p>
    <p>4. Die Meldung von Sicherheitsmängeln oder potenziellen Gefahrensituationen an die
        vorgesetzten Dienststellen. </p>
    <p>5. Die Einhaltung aller relevanten Vorschriften im Zusammenhang mit Erste-Hilfe-Maßnahmen
        und medizinischer Versorgung.
    </p>
    <p>(2) Die Nichteinhaltung dieser Klausel kann disziplinarische Maßnahmen bis hin zur fristlosen
        Kündigung des Arbeitsverhältnisses nach sich ziehen, sofern dadurch die Sicherheit des
        Arbeitnehmers, seiner Kollegen oder Dritter gefährdet wird. </p>
    <h3>§28 Rückzahlungsklausel für Ausbildungskosten
    </h3>
    <p>(1) Im Falle einer vorzeitigen Beendigung des Arbeitsverhältnisses durch den Arbeitnehmer oder einer
        Kündigung seitens des Arbeitgebers innerhalb von 8 Wochen nach Abschluss der Ausbildung, ist der
        Arbeitnehmer verpflichtet, 75% der vom Unternehmen getragenen Ausbildungskosten
        zurückzuzahlen.</p>
    <p>(2) Bei einer vorzeitigen Beendigung oder Kündigung behält sich der Arbeitgeber das Recht vor,
        zusätzliche Schäden geltend zu machen, die über die Rückzahlungsklausel hinausgehen. </p>
    <p>(3) Die Rückzahlungspflicht entfällt, wenn die vorzeitige Beendigung oder Kündigung auf Umstände
        zurückzuführen ist, die nicht im Einflussbereich des Arbeitnehmers liegen, wie beispielsweise
        betriebsbedingte Kündigungen seitens des Arbeitgebers.</p>
    <h3 style="padding-top: 120px">§29 Schlussbestimmungen
    </h3>
    <p>(1) Im Falle der Beendigung des Arbeitsverhältnisses oder der Freistellung ist der
        Arbeitnehmerverpflichtet, unaufgefordert und unverzüglich sämtliche in seinem Besitz befindlichen
        Geschäftsunterlagen, Schlüssel, gegebenenfalls ein Diensthandy, ein gegebenenfalls zur Verfügung
        gestelltes Dienstfahrzeug und sonstige dem Arbeitnehmer vom Arbeitgeber überlassenen
        Arbeitsmittel und Gegenstände an den Arbeitgeber zurückzugeben. Im Falle des Verlustes oder der
        schuldhaften Beschädigung hat der Arbeitnehmer dem Arbeitgeber Schadenersatz zu leisten, der
        gegen Vergütungsansprüche aufgerechnet werden kann. Ein während der Freistellung eventuell
        erzieltes Entgelt aus einer anderweitigen Arbeitstätigkeit ist auf die Vergütung des Arbeitnehmers
        aus diesem Arbeitsverhältnis anzurechnen. </p>
    <p >(2) Die in diesem Arbeitsvertrag getroffenen Regelungen sind abschließend. Mündliche oder
        schriftliche Vereinbarungen außerhalb dieses Vertrages und gegebenenfalls seiner Anlagen wurden
        nicht getroffen. </p>
    <p>(3) Auf diesen Vertrag sowie alle Rechtsstreitigkeiten hieraus, gleich aus welchem Rechtsgrunde, findet
        ausschließlich des materiellen Sachrechts der Bundesrepublik Deutschland Anwendung. Die
        Anwendung der Regeln des internationalen Privatrechts ist ausgeschlossen, soweit sie zu einer
        Anwendung ausländischen Sachrechts führen würde.</p>



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
