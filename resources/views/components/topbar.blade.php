@php
    use App\Helpers\MenuHelper;
    $topBarInfo = MenuHelper::getTopBarInfo();
@endphp

<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-flex align-items-center fixed-top" style="z-index: 9997;">
    <div class="container d-flex justify-content-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope"></i> <a href="mailto:{{ $topBarInfo['email'] }}">{{ $topBarInfo['email'] }}</a>
            <i class="bi bi-phone"></i> {{ $topBarInfo['phone'] }}
        </div>
        <div class="d-none d-lg-flex social-links align-items-center">
            @foreach($topBarInfo['social'] as $social)
                <a href="{{ $social['url'] }}" class="{{ $social['name'] }}">
                    <i class="{{ $social['icon'] }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</div>
