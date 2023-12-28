<div id="layoutSidenav_nav">
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Main Menu</div>
            <a class="nav-link" href="{{route('login')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                Enrollments
            </a>
        </div>
    </div>
    @auth
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{Auth::user()->name}}
    </div>
    @endauth
</nav>
</div>
