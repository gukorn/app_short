<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaxWMS - @yield('title', 'Dashboard')</title>
    {{-- ใช้ @vite ใน Laravel จริง แต่ demo นี้ใช้ CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#0a9e82', hover: '#088a71', light: '#e6f7f4' },
                    },
                    fontFamily: { sans: ['Noto Sans Thai', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@400;500;600&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-sm text-gray-800 antialiased">

<div class="flex h-screen overflow-hidden" x-data="{ sidebarCollapsed: false }">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex-shrink-0 bg-white border-r border-gray-100 flex flex-col overflow-hidden transition-all duration-300"
        :class="sidebarCollapsed ? 'w-14' : 'w-56'">

        {{-- Logo --}}
        <div class="flex items-center gap-2 px-3 py-4 border-b border-gray-100" :class="sidebarCollapsed ? 'justify-center' : ''">
            <span class="text-lg font-bold tracking-tight" :class="sidebarCollapsed ? 'hidden' : ''">
                <span class="text-primary">MAX</span>WMS
            </span>
            <span class="text-lg font-bold tracking-tight" :class="sidebarCollapsed ? '' : 'hidden'">
                <span class="text-primary">M</span>
            </span>
            <button @click="sidebarCollapsed = !sidebarCollapsed" class="text-gray-400 hover:text-gray-600" :class="sidebarCollapsed ? 'hidden' : 'ml-auto'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- User --}}
        <div class="px-3 py-2" :class="sidebarCollapsed ? 'hidden' : ''">
            <button class="w-full flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                <div class="w-7 h-7 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">VL</div>
                <span class="text-xs font-medium truncate">Warehouse Manager</span>
                <svg class="w-3 h-3 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 py-1 overflow-y-auto overflow-hidden">
            @include('partials.sidebar-nav')
        </nav>

        {{-- Bottom User --}}
        <div class="border-t border-gray-100 px-3 py-3 flex items-center gap-2" :class="sidebarCollapsed ? 'justify-center' : ''">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">JD</div>
            <div class="min-w-0" :class="sidebarCollapsed ? 'hidden' : ''">
                <p class="text-xs font-medium truncate">John Doe</p>
                <p class="text-xs text-gray-400 truncate">johndoe@gmail.com</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600" :class="sidebarCollapsed ? 'hidden' : ''">•••</button>
            <button @click="sidebarCollapsed = false" class="text-gray-400 hover:text-gray-600" :class="sidebarCollapsed ? '' : 'hidden'" title="ขยายเมนู">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-100 px-5 py-2.5 flex items-center gap-1.5 text-xs">
            @yield('breadcrumb')
        </header>

        {{-- Toast --}}
        @if(session('success'))
        <div class="mx-5 mt-3" x-data="{ show: true }" x-show="show">
            <div class="bg-gray-800 text-white text-xs rounded-lg px-4 py-2.5 flex items-center gap-2 w-fit">
                <span class="text-green-400">✓</span>
                {{ session('success') }}
                <button @click="show = false" class="ml-2 text-gray-400 hover:text-white">✕</button>
            </div>
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-5">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
