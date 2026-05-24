@php
    use App\Helpers\MenuHelper;
    $menuItems = MenuHelper::getAdminMenu();
    $currentRoute = Route::currentRouteName();
@endphp

<!-- Sidebar -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @foreach($menuItems as $item)
        <li class="nav-item">
            <a class="nav-link {{ $currentRoute === $item['url'] ? '' : 'collapsed' }}"
               href="{{ route($item['url']) }}">
                <i class="{{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>
        </li>
        @endforeach

    </ul>

</aside>
<!-- End Sidebar-->