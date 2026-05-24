@php
    use App\Helpers\MenuHelper;
    $poli = session('dokter_poli', 'Umum');
    $menuItems = MenuHelper::getDoctorMenu($poli);
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
                @if($item['badge'])
                <span class="badge bg-{{ $item['badge']['color'] ?? 'primary' }} ms-auto">
                    {{ $item['badge']['value'] }}
                </span>
                @endif
            </a>
        </li>
        @endforeach

    </ul>

</aside>
<!-- End Sidebar-->