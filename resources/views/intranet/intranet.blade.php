<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://krd.nuscheltech.de/images/lulbf.png" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />





    <title>KRD Fichtenried</title>
    <!-- Bootstrap !!!! -->
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        * {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-family: Figtree, sans-serif
        }
    </style>
</head>

@if(auth()->id()==1 or auth()->id()== 678536308229931028)
    <body class="text-light" style="background-color: deeppink">
@elseif(auth()->id()==688076461353074702)
    <body class="text-light" style="background-color: yellowgreen">
@else
    <body class="bg-dark text-light" >
@endif


<main>
    @yield("content")
</main>
@include("intranet.sidebar")
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', event => {
                // Alle Buttons (type=submit) im Formular finden
                const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');
                submitButtons.forEach(button => {
                    button.disabled = true;
                    if (button.tagName.toLowerCase() === 'button') {
                        button.innerText = 'Bitte warten...'; // Optional: Text anpassen
                    }
                });
            });
        });
    });
</script>

<footer class="text-center text-lg-start footer" id="footer">
    <div class="text-center p-3" style="background-color: rgba(153, 153, 153, 0.05);">
        <p> Made with Love by @eriside</p>

    </div>
</footer>


<style>
    .toast {
        display: none;
        position: absolute;
        top: 3%;
        left: 40%;
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
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
    }

    .container {
        flex: 1;
    }

    footer {
        margin-top: auto;
    }
</style>
</body>
</html>
