<nav class="navbar navbar-expand-lg sticky-top bg-black ">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="{{ route('home') }}" style="padding-right: 30vw">WarGameTracker</a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0 mx-1" id="navbarSupportedContent">
            <div class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
                @auth
                    <a class="nav-link text-white my-nav-link fs-4" href={{ route('matches.index') }}>View Matches</a>
                    <a class="nav-link text-white my-nav-link fs-4" href={{ route('players.index') }}>View Players</a>
                    @if (Auth::user()->is_admin)
                        <a class="nav-link text-white my-nav-link fs-4" href={{ route('matches.create') }}>Add Match</a>
                    @endif
                @else
                    <a class="nav-link text-warning my-nav-link fs-4" href="{{ route('login') }}">Login</a>
                    <a class="nav-link text-success my-nav-link fs-4" href="{{ route('register') }}">Register</a>
                @endauth

                @auth
                    <a class="nav-link text-info my-nav-link fs-4" href={{ route('dashboard.index') }}>User Dashboard</a>
                @endauth
                @auth
                    <div class="text-center m-1">
                        <form id="logout-form" action="{{ route('login.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout now</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    </div>
</nav>
