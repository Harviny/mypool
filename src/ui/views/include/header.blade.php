<header class="header">
    <div class="container">
        <div class="row">
            <div class="logo">
                <div class="logo-inner">
                    <a href="{{ route('index') }}" class="text-hide logo-link"></a>
                    <h1 style="display: none;">BTC.COM 矿池</h1>
                </div>
            </div>
            @if(Auth::user())
                <nav class="nav">
            @else
                <nav class="nav" style="float:right">
            @endif
                <?php
                    $user = Auth::user();
                    if (Route::currentRouteName() == 'index') {
                        $menus  = ['poolStats', 'help'];
                    } elseif (is_null($user)) {
                        $menus = ['poolStats', 'help'];
                    } else {
                        $menus = ['dashboard', 'miners', 'poolStats', 'help'];
                    }
                ?>
                <ul>
                    @foreach ($menus as $m)
                    <li class="nav-item {{ Route::currentRouteName() == $m ? ' active' : '' }}">
                        <a href="{{ route($m) }}">{{  trans('global.menu.' . $m)}}</a>
                    </li>
                    @endforeach
                </ul>
            </nav>

            @include('include.settings-board')

            @include('include.region-board')

        </div>
    </div>
</header>