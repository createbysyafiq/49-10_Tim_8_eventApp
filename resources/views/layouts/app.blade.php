<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pengelolaan Event & Workshop')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen font-sans text-gray-800 flex flex-col justify-between">

    <div>
        <!-- Navbar Polos, Rapi & Sederhana -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 py-3 flex flex-wrap justify-between items-center gap-4">
                
                <!-- Brand Title -->
                <a href="{{ route('dashboard') }}" class="font-bold text-gray-800 text-base flex items-center gap-2">
                    <span class="w-2.5 h-2.5 bg-blue-600 rounded-full inline-block"></span>
                    Sistem Event &amp; Workshop
                </a>

                <!-- Navigation Links & User Menu -->
                <div class="flex items-center space-x-5 text-sm font-medium">
                    @auth
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-0.5' : 'text-gray-600 hover:text-blue-600' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-0.5' : 'text-gray-600 hover:text-blue-600' }}">
                            Event
                        </a>
                        <a href="{{ route('speakers.index') }}" class="{{ request()->routeIs('speakers*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-0.5' : 'text-gray-600 hover:text-blue-600' }}">
                            Pembicara
                        </a>
                        <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets*') || request()->is('ticket*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-0.5' : 'text-gray-600 hover:text-blue-600' }}">
                            Tiket
                        </a>
                        <a href="{{ route('peserta.index') }}" class="{{ request()->routeIs('peserta*') ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-0.5' : 'text-gray-600 hover:text-blue-600' }}">
                            Peserta
                        </a>

                        <!-- User Info & Logout -->
                        <div class="flex items-center pl-4 border-l border-gray-200 space-x-3">
                            <span class="text-xs text-gray-600 font-medium hidden sm:inline">
                                {{ Auth::user()->nama }}
                            </span>
                            @if(Auth::user()->role === 'admin')
                                <span class="bg-rose-100 text-rose-800 text-xs font-semibold px-2 py-0.5 rounded border border-rose-200">Admin</span>
                            @elseif(Auth::user()->role === 'panitia')
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded border border-blue-200">Panitia</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2 py-0.5 rounded border border-emerald-200">Peserta</span>
                            @endif

                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold bg-red-50 hover:bg-red-100 border border-red-200 px-2.5 py-1 rounded transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Login</a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1.5 rounded-md shadow-sm">Daftar Akun</a>
                    @endauth
                </div>

            </div>
        </nav>

        <!-- Flash Message Alert -->
        <div class="max-w-5xl mx-auto px-4 mt-6">
            @if (session('success'))
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-2.5 rounded-md text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-2.5 rounded-md text-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-2.5 rounded-md text-sm mb-4">
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Konten Halaman -->
        <main class="px-4 py-4">
            @yield('content')
        </main>
    </div>

    <!-- Footer Polos Sesuai Standar Akademik -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500">
        &copy; 2026 Sistem Pengelolaan Event &amp; Workshop &bull; Tugas Besar PAW Kelompok 8
    </footer>

</body>
</html>
