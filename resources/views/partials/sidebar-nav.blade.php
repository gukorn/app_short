{{-- resources/views/partials/sidebar-nav.blade.php --}}

@php
    $currentRoute = request()->route()->getName() ?? '';
@endphp

{{-- <ul id="js-nav-menu" class="nav has-active-border active-on-right">
    @foreach (config('menu') as $key => $value)
        @role($value['role'])
            @if (!empty($value['module']))
                <li class="nav-item">
                    <a href="#" class="nav-link dropdown-toggle collapsed" data-tags="{{ $value['name'] }}">
                        <i class="nav-icon {{ $value['icon'] }}"></i>
                        <span class="nav-text fadeable"><span>{{ $value['name'] }}</span></span>
                        <b class="caret fa fa-angle-left rt-n90"></b>
                    </a>
                    <div class="hideable submenu collapse">
                        <ul class="submenu-inner">

                            @foreach ($value['module'] as $key2 => $value2)
                                @role($value2['role'])
                                    @if (!empty($value2['module']))
                                        <li class="nav-item">
                                            <a href="#" class="nav-link dropdown-toggle collapsed"
                                                data-tags="{{ $value2['name'] }}">
                                                @if (!empty($value2['icon']))
                                                    <i class="nav-icon {{ $value2['icon'] }}"></i>
                                                @endif
                                                <span class="nav-text fadeable"><span>{{ $value2['name'] }}</span></span>
                                                <b class="caret fa fa-angle-left rt-n90"></b>
                                            </a>
                                            <div class="hideable submenu collapse">
                                                <ul class="submenu-inner">
                                                    @foreach ($value2['module'] as $key3 => $value3)
                                                        @role($value3['role'])
                                                            <li class="nav-item"><a href="{{ urlAction($value3['link']) }}"
                                                                    class="nav-link"><span
                                                                        class="nav-text"><span>{{ $value3['name'] }}</span>
                                                                        @if (strlen($value3['link']) <= 3 || strstr($value3['link'], 'demo/'))
                                                                            <span class="badge px-1"><i
                                                                                    class="fas fa-times text-140 text-danger-m2"></i></span>
                                                                        @endif
                                                                    </span></a></li>
                                                        @endrole
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                    @else
                                        <li class="nav-item"><a href="{{ urlAction($value2['link']) }}" class="nav-link">
                                                <span class="nav-text">
                                                    <span>{{ $value2['name'] }}</span>
                                                    @if (strlen($value2['link']) <= 3 || strstr($value2['link'], 'demo/'))
                                                        <span class="badge px-1"><i
                                                                class="fas fa-times text-140 text-danger-m2"></i></span>
                                                    @endif
                                                </span>
                                            </a></li>
                                    @endif
                                @endrole
                            @endforeach
                        </ul>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a href="{{ urlAction($value['link']) }}" class="nav-link">
                        <i class="nav-icon {{ $value['icon'] }}"></i>
                        <span class="nav-text fadeable">
                            <span>{{ $value['name'] }}</span>
                            @if (strlen($value['link']) <= 3 || strstr($value['link'], 'demo/'))
                                <span class="badge px-1"><i class="fas fa-times text-140 text-danger-m2"></i></span>
                            @endif
                        </span>
                    </a>
                    <b class="sub-arrow"></b>
                </li>
            @endifv
        @endrole
    @endforeach
</ul> --}}
{{-- resources/views/partials/sidebar-nav.blade.php --}}
{{-- 3 ชั้น | CSS-only ด้วย <details> | ไม่ต้อง Alpine.js --}}

{{-- resources/views/partials/sidebar-nav.blade.php --}}
{{-- 3 ชั้น | CSS-only ด้วย <details> | ไม่ต้อง Alpine.js --}}

<nav id="sidebar-nav" class="space-y-0.5 px-2 py-1">

    @foreach (config('menu') as $value)
        @role($value['role'])
            @php
                $hasChildren = !empty($value['module']);
                $isDemoL1 =
                    empty($value['link']) || strlen($value['link']) <= 3 || str_contains($value['link'] ?? '', 'demo/');

                // เช็ค active ชั้น 1
                $isGroupActive = false;
                if ($hasChildren) {
                    foreach ($value['module'] as $v2) {
                        if (!empty($v2['module'])) {
                            foreach ($v2['module'] as $v3) {
                                if (
                                    !empty($v3['link']) &&
                                    strlen($v3['link']) > 3 &&
                                    !str_contains($v3['link'], 'demo/')
                                ) {
                                    try {
                                        if (request()->is(trim($v3['link'], '/'))) {
                                            $isGroupActive = true;
                                        }
                                    } catch (\Exception $e) {
                                    }
                                }
                            }
                        } else {
                            if (!empty($v2['link']) && strlen($v2['link']) > 3 && !str_contains($v2['link'], 'demo/')) {
                                try {
                                    if (request()->is(trim($v2['link'], '/'))) {
                                        $isGroupActive = true;
                                    }
                                } catch (\Exception $e) {
                                }
                            }
                        }
                    }
                } else {
                    if (!$isDemoL1) {
                        try {
                            $isGroupActive = request()->is(trim($value['link'], '/'));
                        } catch (\Exception $e) {
                        }
                    }
                }
            @endphp

            @if ($hasChildren)
                {{-- ═══════════════════════════════════════
     ชั้น 1 — มีเมนูย่อย
════════════════════════════════════════ --}}
                <details class="group" {{ $isGroupActive ? 'open' : '' }}>

                    <summary
                        class="flex items-center gap-2 px-3 py-2 rounded-lg cursor-pointer
                    list-none [&::-webkit-details-marker]:hidden select-none transition
                    {{ $isGroupActive ? 'text-primary font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                        @if (!empty($value['icon']))
                            <img src="{{ assetV('assets/image/icons/' . $value['icon'] . '.png') }}"
                                class="w-4 h-4 flex-shrink-0" alt="">
                        @endif
                        <span class="text-sm flex-1 truncate">{{ $value['name'] }}</span>
                        <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200 group-open:rotate-180"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>

                    <div class="mt-0.5 space-y-0.5">

                        @foreach ($value['module'] as $value2)
                            @role($value2['role'])
                                @php
                                    $hasGrandChildren = !empty($value2['module']);
                                    $isDemoL2 =
                                        empty($value2['link']) ||
                                        strlen($value2['link']) <= 3 ||
                                        str_contains($value2['link'] ?? '', 'demo/');

                                    // เช็ค active ชั้น 2
                                    $isSubActive = false;
                                    if ($hasGrandChildren) {
                                        foreach ($value2['module'] as $v3) {
                                            if (
                                                !empty($v3['link']) &&
                                                strlen($v3['link']) > 3 &&
                                                !str_contains($v3['link'], 'demo/')
                                            ) {
                                                try {
                                                    if (request()->is(trim($v3['link'], '/'))) {
                                                        $isSubActive = true;
                                                    }
                                                } catch (\Exception $e) {
                                                }
                                            }
                                        }
                                    } else {
                                        if (!$isDemoL2) {
                                            try {
                                                $isSubActive = request()->is(trim($value2['link'], '/'));
                                            } catch (\Exception $e) {
                                            }
                                        }
                                    }
                                @endphp

                                @if ($hasGrandChildren)
                                    {{-- ═══════════════════════════════════════
         ชั้น 2 — มีเมนูย่อยอีก
    ════════════════════════════════════════ --}}
                                    <details class="group/sub" {{ $isSubActive ? 'open' : '' }}>

                                        <summary
                                            class="flex items-center gap-2 pl-8 pr-3 py-1.5 rounded-lg cursor-pointer
                        list-none [&::-webkit-details-marker]:hidden select-none transition text-xs
                        {{ $isSubActive ? 'text-primary font-medium' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                                            @if (!empty($value2['icon']))
                                                <img src="{{ assetV('assets/image/icons/' . $value2['icon'] . '.png') }}"
                                                    class="w-3.5 h-3.5 flex-shrink-0" alt="">
                                            @else
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full bg-current flex-shrink-0 opacity-40"></span>
                                            @endif
                                            <span class="flex-1 truncate">{{ $value2['name'] }}</span>
                                            <svg class="w-3 h-3 flex-shrink-0 transition-transform duration-200 group-open/sub:rotate-180"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </summary>

                                        <div class="mt-0.5 space-y-0.5">

                                            @foreach ($value2['module'] as $value3)
                                                @role($value3['role'])
                                                    @php
                                                        $isDemoL3 =
                                                            empty($value3['link']) ||
                                                            strlen($value3['link']) <= 3 ||
                                                            str_contains($value3['link'] ?? '', 'demo/');
                                                        $isLeafActive =
                                                            !$isDemoL3 && request()->is(trim($value3['link'], '/'));
                                                    @endphp

                                                    {{-- ชั้น 3 --}}
                                                    <a href="{{ !$isDemoL3 ? urlAction($value3['link']) : '#' }}"
                                                        class="flex items-center gap-2 pl-14 pr-3 py-1.5 rounded-lg transition text-xs
                  {{ $isLeafActive ? 'text-white font-medium bg-primary' : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }}">
                                                        <span class="w-1 h-1 rounded-full bg-current flex-shrink-0"></span>
                                                        <span class="truncate">{{ $value3['name'] }}</span>
                                                        @if ($isDemoL3)
                                                            <svg class="w-3 h-3 text-red-400 ml-auto flex-shrink-0" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        @endif
                                                    </a>
                                                @endrole
                                            @endforeach

                                        </div>
                                    </details>
                                @else
                                    {{-- ═══════════════════════════════════════
         ชั้น 2 — ไม่มีชั้น 3
    ════════════════════════════════════════ --}}
                                    <a href="{{ !$isDemoL2 ? urlAction($value2['link']) : '#' }}"
                                        class="flex items-center gap-2 pl-8 pr-3 py-1.5 rounded-lg transition text-xs
              {{ $isSubActive
                  ? 'text-primary font-medium bg-primary/5'
                  : 'text-gray-400 hover:bg-gray-50 hover:text-gray-600' }}">
                                        @if (!empty($value2['icon']))
                                            <img src="{{ assetV('assets/image/icons/' . $value2['icon'] . '.png') }}"
                                                class="w-3.5 h-3.5 flex-shrink-0" alt="">
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-current flex-shrink-0 opacity-40"></span>
                                        @endif
                                        <span class="truncate">{{ $value2['name'] }}</span>
                                        @if ($isDemoL2)
                                            <svg class="w-3 h-3 text-red-400 ml-auto flex-shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </a>
                                @endif
                            @endrole
                        @endforeach

                    </div>
                </details>
            @else
                {{-- ═══════════════════════════════════════
     ชั้น 1 — ไม่มีเมนูย่อย
════════════════════════════════════════ --}}
                <a href="{{ !$isDemoL1 ? urlAction($value['link']) : '#' }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg transition
          {{ $isGroupActive
              ? 'text-primary font-medium bg-primary/5'
              : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}">
                    @if (!empty($value['icon']))
                        <img src="{{ assetV('assets/image/icons/' . $value['icon'] . '.png') }}"
                            class="w-4 h-4 flex-shrink-0" alt="">
                    @endif
                    <span class="text-sm truncate">{{ $value['name'] }}</span>
                    @if ($isDemoL1)
                        <svg class="w-3 h-3 text-red-400 ml-auto flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </a>
            @endif
        @endrole
    @endforeach

</nav>


{{--
<a href="{{ route('dashboard') }}"
    class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition bg-gray-50 text-gray-800 font-medium"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <rect x="3" y="3" width="7" height="7" rx="1" stroke-width="1.5" />
        <rect x="14" y="3" width="7" height="7" rx="1" stroke-width="1.5" />
        <rect x="3" y="14" width="7" height="7" rx="1" stroke-width="1.5" />
        <rect x="14" y="14" width="7" height="7" rx="1" stroke-width="1.5" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">Dashboard</span>
</a>

<a href="#"
    class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">Analytics</span>
</a>

<div x-data="{ open: false }">
    <button @click="open = !open"
        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition"
        :class="sidebarCollapsed ? 'justify-center' : ''">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span :class="sidebarCollapsed ? 'hidden' : ''">อนุมัติ</span>
        <svg :class="sidebarCollapsed ? 'hidden' : ''" class="w-3 h-3 ml-auto text-gray-400 transition-transform"
            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
        <span :class="sidebarCollapsed ? 'hidden' : ''"
            class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 leading-none">24</span>
    </button>
    <div x-show="open && !sidebarCollapsed" class="mt-0.5 space-y-0.5">
        <a href="#"
            class="flex items-center gap-2 pl-9 pr-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 rounded-lg">
            รายการขออนุมัติ <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">24</span>
        </a>
        <a href="#"
            class="flex items-center gap-2 pl-9 pr-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 rounded-lg">
            รายการขออนุมัติ(บัญชี) <span
                class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">24</span>
        </a>
    </div>
</div>

<p class="px-3 pt-3 pb-1 text-[10px] font-semibold text-gray-400 uppercase tracking-widest"
    :class="sidebarCollapsed ? 'hidden' : ''">Vendors</p>

<a href="#"
    class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">จัดการสินค้าขาเข้า</span>
    <span :class="sidebarCollapsed ? 'hidden' : ''"
        class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">3</span>
</a>

<a href="#"
    class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">การเบิกสินค้า</span>
</a>

<div x-data="{ open: true }">
    <button @click="open = !open"
        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg {{ str_starts_with($currentRoute, 'borrow') ? 'bg-primary-light text-primary font-medium' : 'text-gray-500 hover:bg-gray-50' }} transition"
        :class="sidebarCollapsed ? 'justify-center' : ''">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
        </svg>
        <span :class="sidebarCollapsed ? 'hidden' : ''">ยืม-คืนสินค้า</span>
        <svg :class="sidebarCollapsed ? 'hidden' : ''" class="w-3 h-3 ml-auto text-gray-400 transition-transform"
            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open && !sidebarCollapsed" class="mt-0.5 space-y-0.5">
        <a href="{{ route('borrow.index') }}"
            class="flex items-center pl-9 pr-3 py-1.5 text-xs rounded-lg bg-primary/10 text-primary font-medium ">
            จัดการการยืมคืนสินค้า
        </a>
        <a href="#"
            class="flex items-center pl-9 pr-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 rounded-lg">จัดการการคืนสินค้า</a>
        <a href="#"
            class="flex items-center pl-9 pr-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 rounded-lg">หยิบและตรวจสอบสินค้า</a>
        <a href="#"
            class="flex items-center pl-9 pr-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 rounded-lg">แพ็คสินค้าและจัดส่งสินค้า</a>
    </div>
</div>

<a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">จัดการสินค้า</span>
</a>

<a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">รายงาน</span>
</a>

<a href="#" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-500 hover:bg-gray-50 transition"
    :class="sidebarCollapsed ? 'justify-center' : ''">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    <span :class="sidebarCollapsed ? 'hidden' : ''">ตั้งค่าระบบ</span>
</a> --}}
