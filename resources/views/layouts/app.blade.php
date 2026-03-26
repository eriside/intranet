<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Berufsfeuerwehr</title>
    <!-- Bootstrap !!!! -->
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">



    <!-- Styles -->
    <style>
        * {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-family: Figtree, sans-serif
        }
    </style>
</head>
<body class="bg-dark text-light">
@include("nav")
<main>
    @yield("content")
</main>



<!-- MSG -->

@if(session("msg"))

    <span class="toast" id="liveToast">
    {!! session("msg") !!}
    <button onclick="hideToast()">X</button>
</span>


    <script>
        showToast();
        function showToast() {
            var toast = document.getElementById('liveToast');
            toast.style.display = 'block';
            setTimeout(function () {
                hideToast();
            }, 5000); // Hide the toast after 3 seconds
        }

        function hideToast() {
            var toast = document.getElementById('liveToast');
            toast.style.display = 'none';
        }
    </script>
@endif

</body>
<footer class="text-center text-lg-start" id="footer">
    <div class="text-center p-3" style="background-color: rgba(153, 153, 153, 0.05);">
        <p> Es handelt sich um ein rein fiktives Angebot! Diese Website ist für den privaten Gebrauch auf dem GamingLife Server bestimmt.</p>
        <p>GamingLife IS NOT APPROVED, SPONSORED, OR ENDORSED BY ROCKSTARGAMES</p>
    </div>

</footer>

<style>
    .toast {
        display: none;
        position: absolute;
        top: 3%;
        left: 40%;
        /*transform: translate(-50%, -200%);*/
        background-color: #007bff;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 20%;
    }

    .toast button {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        float: right;
        font-size: 20px;
    }
    html, body {
        height: 100%; /* Sicherstellen, dass der Body die volle Höhe des Bildschirms hat */
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1; /* Der Container nimmt den verfügbaren Platz ein */
    }

    footer {
        margin-top: auto; /* Der Footer wird immer nach unten verschoben */
    }








</style>
<style>
    .toast {
        display: none;
        position: absolute;
        top: 3%;
        left: 40%;
        /*transform: translate(-50%, -200%);*/
        background-color: #007bff;
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 20%;
    }

    .toast button {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0;
        float: right;
        font-size: 20px;
    }
    html, body {
        height: 100%; /* Sicherstellen, dass der Body die volle Höhe des Bildschirms hat */
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1; /* Der Container nimmt den verfügbaren Platz ein */
    }

    footer {
        margin-top: auto; /* Der Footer wird immer nach unten verschoben */
    }








</style>
</html>
