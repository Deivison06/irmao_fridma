<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Plataforma Cristino Castro Online</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Melhorias de responsividade */
        @media (max-width: 768px) {
            .flex.h-screen {
                flex-direction: column;
            }

            aside {
                width: 100%;
                height: auto;
            }

            #map {
                height: 300px;
            }
        }
    </style>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    @stack('styles')
</head>

<body class="h-full text-gray-900 bg-gray-100">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside
            class="flex flex-col justify-between w-64 p-4 bg-gradient-to-b from-[#145156] to-[#0596A2] text-white shadow-lg flex-shrink-0">
            <!-- Topo com logo -->
            <div class="flex flex-col items-center space-y-6">
                <a href="#"><img src="{{ url('logos/logo.png') }}" alt="Logo Prefeitura"
                        class="w-40 mb-4" /></a>

                <!-- Navegação -->
                <nav class="w-full space-y-1" aria-label="Navegação principal">
                    <!-- Dashboard -->
                    @can('gerenciar conteudo')
                        <a href="#"
                            class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A4 4 0 018 17h8a4 4 0 012.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @endcan

                    <div class="pt-2 mt-4 border-t border-white/20">
                        <h3 class="px-4 mb-2 text-xs font-semibold tracking-wider uppercase text-white/70">Conteúdo do
                            Site</h3>

                        @can('gerenciar conteudo')
                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                    {{ request()->routeIs('admin.cards.servicos.*') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Card Serviço ONLINE</span>
                            </a>

                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                    {{ request()->routeIs('admin.cards.solicitacoes.*') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <span>Card Solicitação</span>
                            </a>
                        @endcan

                        {{-- @role(['admin', 'master']) --}}
                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                    {{ request()->routeIs('admin.solicitacoes.index') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Todas as Solicitações</span>
                            </a>
                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                            {{ request()->routeIs('admin.alvaras.index') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Todos os Alvarás</span>
                            </a>
                        {{-- @endrole

                        @role('cidadao') --}}
                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                    {{ request()->routeIs('admin.minhas-solicitacoes.index') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Minhas Solicitações</span>
                            </a>
                            <a href="#"
                                class="flex items-center px-4 py-3 space-x-3 rounded-lg transition-all
                                    {{ request()->routeIs('admin.citizen.alvaras.index') ? 'bg-white text-[#145156] shadow-md' : 'text-white hover:bg-white/20' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Meus Alvarás</span>
                            </a>
                        {{-- @endrole --}}
                    </div>
                </nav>
            </div>

            <!-- Rodapé com botão sair e logo -->
            <div class="flex flex-col items-center w-full max-w-xs mx-auto space-y-4">
                <!-- Botão Sair -->
                <form method="POST" action="#">
                    @csrf
                    <button type="submit"
                        class="flex items-center justify-center w-full px-6 py-2 space-x-2 font-bold text-[#145156] bg-white rounded-lg transition-colors hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#145156]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sair</span>
                    </button>
                </form>

                <a href="#"
                    class="flex items-center px-4 py-2 space-x-2 font-bold text-[#145156] bg-white rounded-lg transition-colors hover:bg-[#dadada] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#145156] border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Perfil</span>
                </a>

                <!-- Logo -->
                <img src="{{ asset('logos/soft-logo.png') }}" alt="Logo Soft"
                    class="mt-4 transition-opacity w-28 opacity-90 hover:opacity-100">
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex flex-col flex-1 overflow-y-auto">
            <!-- Header -->
            <header class="flex-shrink-0 px-6 py-4 bg-white border-b shadow-sm">
                <h1 class="text-2xl font-semibold">{{ $header ?? 'Administração' }}</h1>
            </header>

            <!-- Page Content -->
            <div class="flex-1 p-6 overflow-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Alpine JS for dropdown functionality -->
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>

</html>
