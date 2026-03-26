<button id="toggle-sidebar" class="toggle-btn">
    <i class="fas fa-bars"></i>
</button>
<div class="sidebar collapsed">
    <h4>Intranet</h4>
    @if($roles->contains('Mitarbeiter') || $roles->contains('Beförderung') || $roles->contains('Inaktive Mitarbeiter') || $roles->contains('Eingestempelte Mitarbeiter') || $roles->contains('Archiv') || $roles->contains('Verwaltungsleitung') || $roles->contains('Kats'))
        <a href="#ver" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center collapsed">
            <span><i class="fas fa-cogs"></i> Verwaltung</span>
            <i class="fas fa-chevron-down toggle-icon"></i>
        </a>

        <div class="collapse" id="ver">

            @if($roles->contains('Mitarbeiter'))
                <a href="{{url('/intranet/verwaltung/mitarbeiter')}}"><i class="fas fa-users"></i> Mitarbeiter</a>
            @endif
            @if($roles->contains('Inaktive Mitarbeiter'))
                <a href="{{url('/intranet/verwaltung/mitarbeiter/inaktiv')}}"><i class="fas fa-user-slash"></i> Inaktive Mitarbeiter</a>
            @endif
            @if($roles->contains('Eingestempelte Mitarbeiter'))
                <a href="{{url('/intranet/verwaltung/eingestempelt')}}"><i class="fas fa-user-clock"></i> Eingestempelte Mitarbeiter</a>
            @endif
            @if($roles->contains('Archiv'))
                <a href="{{url('/intranet/verwaltung/mitarbeiter/archiv')}}"><i class="fas fa-archive"></i> Archiv</a>
            @endif


        </div>
    @endif

    @if($roles->contains('Ränge') || $roles->contains('Dokumententyp') || $roles->contains('Berechtigungen') || $roles->contains('Stempeluhr Log') || $roles->contains('Rollen'))
        <a href="#admin" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center collapsed">
            <span><i class="fas fa-tools"></i> Administration</span>
            <i class="fas fa-chevron-down toggle-icon"></i>
        </a>
        <div class="collapse" id="admin">

            @if($roles->contains('Dokumententyp'))
                <a href="{{url('/intranet/admin/dokumententyp')}}"><i class="fas fa-file-alt"></i> Dokumententyp</a>
            @endif
            @if($roles->contains('Berechtigungen'))
                <a href="{{url('/intranet/admin/berechtigungen')}}"><i class="fas fa-lock"></i> Berechtigungen</a>
            @endif
            @if($roles->contains('Rollen'))
                <a href="{{url('/intranet/admin/rollen')}}"><i class="fas fa-users-cog"></i> Rollen</a>
            @endif
            @if($roles->contains('Ausbildungen'))
                <a href="{{url('/landesschule/ausbildungen/')}}"><i class="fas fa-graduation-cap"></i> Ausbildungen</a>
            @endif
            @if($roles->contains('Stempeluhr Log'))
                <a href="{{url('/intranet/admin/stempeluhr')}}"><i class="fas fa-clock"></i> Stempeluhr Log</a>
            @endif
        </div>
    @endif

    @if($roles->contains('Ausbilder') or $roles->contains('Zeugnisse') or $isAusbilder)
        <a href="#schule" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center collapsed">
            <span><i class="fas fa-tools"></i> Landesschule</span>
            <i class="fas fa-chevron-down toggle-icon"></i>
        </a>
        <div class="collapse" id="schule">
            @if($roles->contains('Zeugnisse'))
                <a href="{{url('landesschule/zeugnisse')}}"><i class="fas fa-file"></i> Zeugnisse</a>
            @endif
            @if($roles->contains('Ausbilder'))
                <a href="{{url('/landesschule/ausbilder/')}}"><i class="fas fa-chalkboard-teacher"></i> Ausbilder</a>
            @endif
            @if($isAusbilder)
                    <a href="{{url('/landesschule/ausbildungsangebote/')}}"><i class="fas fa-clipboard-list"></i> Ausbildungsangebote</a>
            @endif

        </div>
    @endif



    @if($roles->contains('Changelog Senden') || $roles->contains('To Do'))
        <a href="#lei" data-bs-toggle="collapse" class="d-flex justify-content-between align-items-center collapsed">
            <span><i class="fas fa-users-cog"></i> Leitung</span>
            <i class="fas fa-chevron-down toggle-icon"></i>
        </a>
        <div class="collapse" id="lei">
            @if($roles->contains('To Do'))
                <a href="{{url('/intranet/todo')}}"><i class="fas fa-tasks"></i> To Do</a>
            @endif
            @if($roles->contains('Changelog Senden'))
                <a href="{{url('/intranet/changelog')}}"><i class="fas fa-file-alt"></i> Changelog Senden</a>
            @endif
        </div>
    @endif

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>


    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggle-sidebar");
        const sidebar = document.querySelector(".sidebar");

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("collapsed");

            // Falls Sidebar einklappt, alle geöffneten Menüs schließen
            if (sidebar.classList.contains("collapsed")) {
                document.querySelectorAll(".collapse.show").forEach((menu) => {
                    new bootstrap.Collapse(menu, { toggle: false }).hide();
                });
            }
        });
    });
        document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
    });



// Dreh-Animation für die Pfeile bei Dropdowns
        document.querySelectorAll('.sidebar a[data-bs-toggle="collapse"]').forEach((element) => {
            element.addEventListener("click", function () {
                this.classList.toggle("collapsed");
            });
        });


</script>
<style>
    body {
        display: flex;
        font-family: 'Arial', sans-serif;
    }

    /* Standard-Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        background: #212529;
        padding: 15px;
        overflow-y: auto;
        transition: transform 0.3s ease-in-out;
    }

    /* Sidebar komplett verstecken (außer Button) */
    .sidebar.collapsed {
        transform: translateX(-100%);
    }

    /* Toggle-Button bleibt sichtbar */
    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 15px;
        background: #212529;
        border: none;
        color: #f8f9fa;
        font-size: 20px;
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 5px;
        z-index: 1000;
    }

    /* Button bewegt sich nach rechts, wenn Sidebar ausgeklappt ist */
    .sidebar:not(.collapsed) .toggle-btn {
        left: 260px;
    }

    /* Button-Animation */
    .toggle-btn i {
        transition: transform 0.3s ease;
    }

    /* Button dreht sich beim Einklappen */
    .sidebar.collapsed .toggle-btn i {
        transform: rotate(180deg);
    }




    .sidebar h4 {
        color: #f8f9fa;
        text-align: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #495057;
    }

    .sidebar a {
        color: #f8f9fa;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 12px;
        border-radius: 5px;
        transition: background 0.3s, padding-left 0.3s;
    }

    .sidebar a:hover {
        background: #495057;
        padding-left: 15px;
    }

    .sidebar i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .collapse a {
        padding-left: 35px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .collapse.show a {
        padding-left: 40px;
    }



    /* Styling für den Pfeil */
    .toggle-icon {
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .collapsed .toggle-icon {
        transform: rotate(-90deg);
    }
</style>
