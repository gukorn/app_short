<div class="sidebar-nav">

    @foreach (config('menu') as $i => $menu)
        @role($menu['role'])
            @if (!empty($menu['module']))
                @php
                    $colId = 'menu-l1-' . $i;
                    $isOpen = false;
                    foreach ($menu['module'] as $sub) {
                        if (!empty($sub['module'])) {
                            foreach ($sub['module'] as $sub2) {
                                if (isset($sub2['link']) && request()->is(ltrim($sub2['link'], '/'))) {
                                    $isOpen = true;
                                    break 2;
                                }
                            }
                        }
                        if (isset($sub['link']) && request()->is(ltrim($sub['link'], '/'))) {
                            $isOpen = true;
                            break;
                        }
                    }
                @endphp

                <div class="nav-item-l1">
                    <a class="nav-link-l1 {{ $isOpen ? 'active' : '' }}" data-label="{{ $menu['name'] }}"
                        data-bs-toggle="collapse" href="#{{ $colId }}"
                        aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                        @if (!empty($menu['img']))
                            <img src="{{ assetV($menu['img']) }}" class="nav-icon">
                        @elseif (!empty($menu['icon']))
                            <i class="{{ $menu['icon'] }} nav-icon"></i>
                        @endif
                        <span class="nav-label">{{ $menu['name'] }}</span>
                        @if (!empty($menu['badge']))
                            <span class="nav-badge">{{ $menu['badge'] }}</span>
                        @endif
                        <i class="bi bi-chevron-down nav-arrow ms-auto"></i>
                    </a>

                    <ul class="nav-sub-l2 collapse {{ $isOpen ? 'show' : '' }}" id="{{ $colId }}">
                        @foreach ($menu['module'] as $j => $sub)
                            @role($sub['role'])
                                @if (!empty($sub['module']))
                                    @php
                                        $colId2 = 'menu-l2-' . $i . '-' . $j;
                                        $isOpen2 = false;
                                        foreach ($sub['module'] as $sub2) {
                                            if (isset($sub2['link']) && request()->is(ltrim($sub2['link'], '/'))) {
                                                $isOpen2 = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    <li>
                                        <a class="nav-link-l2 {{ $isOpen2 ? 'active' : '' }}" data-bs-toggle="collapse"
                                            href="#{{ $colId2 }}" aria-expanded="{{ $isOpen2 ? 'true' : 'false' }}">
                                            @if (!empty($sub['icon']))
                                                <i class="{{ $sub['icon'] }}"></i>
                                            @endif
                                            <span class="nav-label">{{ $sub['name'] }}</span>
                                            <i class="bi bi-chevron-down nav-arrow ms-auto"></i>
                                        </a>

                                        <ul class="nav-sub-l3 collapse {{ $isOpen2 ? 'show' : '' }}"
                                            id="{{ $colId2 }}">
                                            @foreach ($sub['module'] as $sub2)
                                                @role($sub2['role'])
                                                    @php
                                                        $isActive3 =
                                                            isset($sub2['link']) &&
                                                            request()->is(ltrim($sub2['link'], '/'));
                                                        $isDemo =
                                                            isset($sub2['link']) &&
                                                            (strlen($sub2['link']) <= 3 ||
                                                                str_contains($sub2['link'], 'demo/'));
                                                    @endphp
                                                    <li>
                                                        <a href="{{ urlAction($sub2['link']) }}"
                                                            class="nav-link-l3 {{ $isActive3 ? 'active' : '' }}">
                                                            {{ $sub2['name'] }}
                                                            @if ($isDemo)
                                                                <i class="bi bi-x-circle text-danger ms-1"
                                                                    style="font-size:11px;"></i>
                                                            @endif
                                                        </a>
                                                    </li>
                                                @endrole
                                            @endforeach
                                        </ul>
                                    </li>

                                @else
                                    @php
                                        $isActive2 = isset($sub['link']) && request()->is(ltrim($sub['link'], '/'));
                                        $isDemo2 =
                                            isset($sub['link']) &&
                                            (strlen($sub['link']) <= 3 || str_contains($sub['link'], 'demo/'));
                                    @endphp
                                    <li>
                                        <a href="{{ urlAction($sub['link']) }}"
                                            class="nav-link-l2 {{ $isActive2 ? 'active' : '' }}">
                                            @if (!empty($sub['icon']))
                                                <i class="{{ $sub['icon'] }}"></i>
                                            @endif
                                            <span class="nav-label">
                                                {{ $sub['name'] }}
                                                @if ($isDemo2)
                                                    <i class="bi bi-x-circle text-danger ms-1" style="font-size:11px;"></i>
                                                @endif
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endrole
                        @endforeach

                    </ul>
                </div>

            @else
                @php
                    $isActiveL1 = isset($menu['link']) && request()->is(ltrim($menu['link'], '/'));
                    $isDemoL1 =
                        isset($menu['link']) && (strlen($menu['link']) <= 3 || str_contains($menu['link'], 'demo/'));
                @endphp
                <a href="{{ urlAction($menu['link']) }}" class="nav-link-l1 {{ $isActiveL1 ? 'active' : '' }}"
                    data-label="{{ $menu['name'] }}">
                    @if (!empty($menu['img']))
                        <img src="{{ assetV($menu['img']) }}" class="nav-icon">
                    @elseif (!empty($menu['icon']))
                        <i class="{{ $menu['icon'] }} nav-icon"></i>
                    @endif
                    <span class="nav-label">
                        {{ $menu['name'] }}
                        @if ($isDemoL1)
                            <i class="bi bi-x-circle text-danger ms-1" style="font-size:11px;"></i>
                        @endif
                    </span>
                </a>
            @endif
        @endrole
    @endforeach

</div>
