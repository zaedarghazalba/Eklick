@php
    use App\Helpers\MenuHelper;
    $menuItems = MenuHelper::getUserMenu();
    $currentPath = request()->path();
@endphp

<!-- ======= Header ======= -->
<header id="header" class="fixed-top" style="z-index: 9998;">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="{{ route('home') }}">{{ $title ?? 'Electronik Klinik' }}</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="{{ route('home') }}" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                @foreach($menuItems as $item)
                    <li>
                        <a class="nav-link {{ $item['class'] ?? '' }} {{ $item['active'] ? 'active' : '' }}"
                           href="{{ $item['url'] }}">
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        <a href="/logout" class="appointment-btn scrollto">{{ $logoutText ?? 'Logout' }}</a>

    </div>
</header><!-- End Header -->
