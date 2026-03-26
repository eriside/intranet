<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://krd.nuscheltech.de/images/lulbf.png" rel="icon">
    <title>KRD Fichtenried - Admin</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Admin Styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-nav {
            background-color: #343a40 !important;
        }
    </style>
</head>
<body onload="checkPassword()">
    <div id="passwort" style="display:none;">

        <!-- Admin Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark admin-nav mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/dashboard') }}">KRD Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="adminNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Zurück zur Website</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard/leitung') }}">Leitung</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard/fuhrpark') }}">Fuhrpark</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard/berichte') }}">Berichte</a></li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-flex">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="container">
            @yield("content")
        </main>

        <!-- MSG -->
        @if(session("msg"))
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
                <div id="liveToast" class="toast show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {!! session("msg") !!}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(function () {
                    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
                    var toastList = toastElList.map(function (toastEl) {
                        return new bootstrap.Toast(toastEl)
                    })
                    toastList.forEach(toast => toast.hide());
                }, 5000);
            </script>
        @endif

    </div>

    <script>
        const correctPassword = 'bf';
        const timeoutDuration = 10 * 60 * 1000; // 10 Minuten bis zur erneuten Abfrage

        function checkPassword() {
            if (sessionStorage.getItem('authenticated') === 'true') {
                document.getElementById('passwort').style.display = 'block';
                return;
            }

            const userPassword = prompt('Bitte gib das Passwort ein:');

            if (userPassword === correctPassword) {
                sessionStorage.setItem('authenticated', 'true');
                document.getElementById('passwort').style.display = 'block';

                setTimeout(() => {
                    sessionStorage.removeItem('authenticated');
                    alert('Deine Sitzung ist abgelaufen. Bitte gib das Passwort erneut ein.');
                    location.reload();
                }, timeoutDuration);

            } else {
                alert('Falsches Passwort. Bitte versuche es erneut.');
                checkPassword();
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            checkPassword();
        });
    </script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>
