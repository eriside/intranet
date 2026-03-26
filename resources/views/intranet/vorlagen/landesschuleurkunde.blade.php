<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>Ausbildungszeugnis</title>

        <style>
            @page {
                margin: 0;
            }
            table td:nth-child(2) {
                text-align: right;
            }
            .signature {
                font-family: "Lucida Handwriting", cursive;
                font-size: 36px;
            }



        </style>
    </head>
    <body>
    @php
        $path = public_path('images/1Landesakademie_V4.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    @endphp

    <img src="{{ $base64 }}" alt="Bild" style="width:290px; position: absolute; right: 50px; top: 10px">
        <p style="position: absolute; left: 60px; top: 50px; font-size: 20px"><strong>Landes Feuerwehr-</strong></p>
        <p style="position: absolute; left: 60px; top: 70px; font-size: 20px"><strong>und Rettungsdienstakademie</strong></p>
        <p style="position: absolute; left: 150px; top: 145px; font-size: 50px"><strong>Urkunde</strong></p>
        <div style="display: flex; justify-content: center; align-items: center; height: 100%; text-align: center;">
            <p style="font-size: 25px; margin: 0; padding-top: 350px"><strong>{{$name}}</strong></p>
            <p style="font-size: 25px; margin: 0; padding-top: 10px"><strong>geb. {{$genurtsdatum}}</strong></p>
            <p style="font-size: 25px; margin: 0; padding-top: 50px"><strong>hat am {{\Carbon\Carbon::parse($datum)->format('d.m.Y')}} an einem Lehrgang</strong></p>
            <p style="font-size: 25px; margin: 0; padding-top: 30px"><strong>{{$ausbildungname}}</strong></p>
            <p style="font-size: 20px; margin: 0; padding-top: 50px">nach den aktuellen Vorgaben der</p>
            <p style="font-size: 20px; margin: 0; padding-top: 20px">Berufsfeuerwehr mit Erfolg teilgenommen. </p>
        </div>
        <table style="position: absolute; top: 650px; width: 100%; padding: 60px" >
            <tr>
                <td>Rheinstadt der, {{\Carbon\Carbon::parse($datum2)->format('d.m.Y')}}</td>
                <td>Rheinstadt der, {{\Carbon\Carbon::now()->format('d.m.Y')}}</td>
            </tr>
            <tr>
                <td class="signature">{{$ausbilder}}</td>
                <td class="signature">{{$schulleitung}}</td>
            </tr>
            <tr>
                <td><hr></td>
                <td><hr></td>
            </tr>
            <tr>
                <td>{{$ausbilder}}</td>
                <td>{{$schulleitung}}</td>
            </tr>
            <tr>
                <td><strong>Lehrgangsleiter</strong></td>
                <td><strong>Ausbildungsleitung</strong></td>
            </tr>

        </table>
        <p style="position: absolute; top: 850px; left: 60px">Name der ermächtigten Stelle: Landes Feuerwehr- und Rettungsdienstakademie</p>
        <p style="position: absolute; top: 880px; left: 60px">Registriernummer des Lehrgangs: {{$id}}</p>
        <div style="display: flex; justify-content: center; align-items: center;  text-align: center;">
            <p style="font-size: 12px; margin-top: -150px">Landes Feuerwehr- und Rettungsdienstakademie</p>
            <p style="font-size: 12px; ">8208, Rheinstadt</p>
            <a style="font-size: 12px; color: black; " href="{{url('/')}}">{{url('/')}}</a>
            <p style="font-size: 12px; ">Dieses Dokument dient nur zur Verwendung in einem Roleplay Projekt und stellt keine Urkundenfälschung dar.</p>
            <p style="font-size: 12px; ">Das Dokument ist kein Echtheitszertifikat und vollständig fiktiv. </p>
        </div>







    </body>
</html>
