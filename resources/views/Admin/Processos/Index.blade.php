@extends('layouts.app')
@section('page-title', 'Gestão de Processos')
@section('page-subtitle', 'Gerencie todos os processos licitatórios de forma centralizada')

@section('content')
    <div class="py-8">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Botão Novo Processo -->
            <div class="flex justify-end mb-8">
                <a href="{{ route('admin.processos.create') }}"
                    class="inline-flex items-center gap-3 px-6 py-3 text-sm font-semibold text-white transition-all duration-200 bg-gradient-to-r from-[#009496] to-[#007a7a] rounded-xl hover:from-[#007a7a] hover:to-[#005f5f] hover:shadow-lg hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
                    </svg> Novo Processo </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="p-4 mb-8 border border-green-200 shadow-sm rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Prefeituras Cards -->
            <div class="mb-8">
                <!-- Botão Voltar -->
                <div id="btn-voltar-container" class="hidden mb-4">
                    <button id="btn-voltar"
                        class="px-4 py-2 text-sm font-medium text-white bg-[#009496] rounded-lg hover:bg-[#007a7a] transition-all duration-200">
                        ← Voltar
                    </button>
                </div>

                <div id="prefeituras-cards">
                    <h2 class="mb-4 text-xl font-semibold text-gray-800">Selecione uma Prefeitura</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4" >
                        @foreach ($prefeituras as $prefeitura)
                            <a href="{{ route('admin.processos.index') }}?prefeitura_id={{ $prefeitura->id }}"
                                class="prefeitura-card group relative p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-[#009496] transition-all duration-300 transform hover:-translate-y-1"
                                data-prefeitura-id="{{ $prefeitura->id }}">
                                <div
                                    class="absolute transition-opacity duration-300 opacity-0 top-4 right-4 group-hover:opacity-100">
                                    <svg class="w-5 h-5 text-[#009496]" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex items-center mb-3">
                                    <div class="p-2 rounded-lg bg-[#009496]/10">
                                        <svg class="w-6 h-6 text-[#009496]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                <h3
                                    class="text-lg font-semibold text-gray-800 group-hover:text-[#009496] transition-colors duration-300">
                                    {{ $prefeitura->nome }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ $prefeitura->email }}</p>
                                <div class="pt-3 mt-3 border-t border-gray-100">
                                    <span class="text-xs font-medium text-[#009496] bg-[#009496]/10 px-2 py-1 rounded-full">
                                        {{ $processos->where('prefeitura_id', $prefeitura->id)->count() }} processos
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Filtro Ativo -->
            @if (request('prefeitura_id'))
                <div class="p-4 mb-6 border border-blue-200 bg-blue-50 rounded-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-blue-800">
                                Filtrado por: {{ $prefeituras->find(request('prefeitura_id'))->nome }}
                            </span>
                        </div>
                        <a href="{{ route('admin.processos.index') }}" class="text-sm text-blue-600 hover:text-blue-800">
                            Limpar filtro
                        </a>
                    </div>
                </div>
            @endif

            <!-- Tabela de Processos -->
            <div class="overflow-hidden bg-white border border-gray-100 shadow-sm rounded-2xl">
                <!-- Header da Tabela -->
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex flex-col items-start justify-between lg:flex-row lg:items-center">
                        <h3 class="text-xl font-semibold text-gray-800">Processos Licitatórios</h3>
                        <span class="mt-2 text-sm text-gray-500 lg:mt-0">
                            Total: {{ $processos->total() }} processos
                        </span>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Prefeitura
                                </th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Modalidade
                                </th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Nº Processo
                                </th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Nº Procedimento
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($processos as $processo)
                                <!-- Linha 1: dados principais -->
                                <tr class="transition-colors duration-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-8 h-8 rounded-full bg-[#009496]/10 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-[#009496]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-6 0H5m2 0h4M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $processo->prefeitura->nome }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-0.5 text-xs font-medium rounded-full
                                            @if ($processo->modalidade->value === 'dispensa') bg-purple-100 text-purple-800
                                            @elseif($processo->modalidade->value === 'inexigibilidade') bg-pink-100 text-pink-800
                                            @elseif($processo->modalidade->value === 'pregão') bg-blue-100 text-blue-800
                                            @elseif($processo->modalidade->value === 'concorrência') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $processo->modalidade->getDisplayName() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->numero_processo }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-sm text-gray-900">
                                        {{ $processo->numero_procedimento }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.processos.edit', $processo->id) }}"
                                                class="p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-gray-100 hover:text-[#009496]"
                                                title="Editar processo">
                                                ✏️
                                            </a>
                                            <a href="{{ route('admin.processos.iniciar', $processo->id) }}"
                                                 class="p-2 text-white transition-colors duration-200 bg-[#009496] rounded-lg hover:bg-[#007a7a]"
                                                title="Iniciar processo">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin-="round"
                                                        stroke-width="2"
                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('admin.processos.destroy', $processo->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="return confirm('Tem certeza que deseja excluir este processo?')"
                                                    class="p-2 text-gray-600 transition-colors duration-200 rounded-lg hover:bg-red-100 hover:text-red-600"
                                                    title="Excluir processo">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Linha 2: objeto -->
                                <tr class="bg-gray-50">
                                    <td colspan="5" class="px-6 py-4 text-sm text-gray-700">
                                        <strong>Objeto:</strong> {{ $processo->objeto }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-400">
                                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <p class="text-lg font-medium text-gray-500">Nenhum processo encontrado</p>
                                            <p class="mt-1 text-sm text-gray-400">Comece criando seu primeiro processo</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                @if ($processos->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $processos->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para Visualizar Objeto Completo -->
    <div id="objeto-modal" class="fixed inset-0 z-50 hidden overflow-y-auto transition-opacity duration-300 ease-in-out">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"></div>
            </div>

            <!-- Centralização do modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Conteúdo do Modal -->
            <div
                class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl sm:align-middle">
                <!-- Header do Modal -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-800" id="modal-objeto-title">
                        <span class="text-[#009496]">📋</span> Objeto do Processo
                    </h3>
                    <button type="button" id="btn-close-objeto-modal"
                        class="text-gray-400 transition-colors duration-200 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Conteúdo -->
                <div class="mt-6">
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-500">Número do Processo:</h4>
                        <p id="modal-processo-numero" class="font-mono text-lg text-gray-900"></p>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Objeto Completo:</h4>
                        <div id="modal-objeto-content" class="p-4 mt-2 overflow-y-auto rounded-lg bg-gray-50 max-h-96">
                            <p class="leading-relaxed text-gray-800 whitespace-pre-wrap"></p>
                        </div>
                    </div>
                </div>

                <!-- Footer do Modal -->
                <div class="flex items-center justify-end pt-6 mt-6 border-t border-gray-100">
                    <button type="button" id="btn-copy-objeto"
                        class="px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-200 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Copiar Texto
                    </button>
                    <button type="button" id="btn-close-objeto-modal-2"
                        class="px-6 py-2 ml-3 text-sm font-medium text-white bg-[#009496] rounded-lg shadow-sm hover:bg-[#007a7a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#009496] transition-all duration-200">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        .hover\:scale-105:hover {
            transform: scale(1.05);
        }

        .hover\:-translate-y-1:hover {
            transform: translateY(-0.25rem);
        }

        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .objeto-cell:hover {
            background-color: #f8fafc;
            border-radius: 0.375rem;
        }

        #objeto-modal {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        #objeto-modal:not(.hidden) {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal Objeto
            const objetoModal = document.getElementById('objeto-modal');
            const modalProcessoNumero = document.getElementById('modal-processo-numero');
            const modalObjetoContent = document.getElementById('modal-objeto-content');
            const copyButton = document.getElementById('btn-copy-objeto');

            document.querySelectorAll('.objeto-cell').forEach(cell => {
                cell.addEventListener('click', function() {
                    modalProcessoNumero.textContent = this.dataset.processo;
                    modalObjetoContent.querySelector('p').textContent = this.dataset.objeto;
                    objetoModal.classList.remove('hidden');
                });
            });

            function closeObjetoModal() {
                objetoModal.classList.add('hidden');
            }

            document.getElementById('btn-close-objeto-modal').addEventListener('click', closeObjetoModal);
            document.getElementById('btn-close-objeto-modal-2').addEventListener('click', closeObjetoModal);
            objetoModal.addEventListener('click', e => {
                if (e.target === objetoModal) closeObjetoModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeObjetoModal();
            });

            copyButton.addEventListener('click', function() {
                const texto = modalObjetoContent.querySelector('p').textContent;
                navigator.clipboard.writeText(texto).then(() => {
                    const originalText = copyButton.innerHTML;
                    copyButton.innerHTML = '✅ Copiado!';
                    copyButton.classList.add('bg-green-100', 'text-green-800');
                    setTimeout(() => {
                        copyButton.innerHTML = originalText;
                        copyButton.classList.remove('bg-green-100', 'text-green-800');
                    }, 2000);
                }).catch(err => alert('Erro ao copiar texto.'));
            });

            // Prefeituras Cards
            const cardsContainer = document.getElementById('prefeituras-cards');
            const btnVoltar = document.getElementById('btn-voltar');
            const btnVoltarContainer = document.getElementById('btn-voltar-container');

            document.querySelectorAll('.prefeitura-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    const prefeituraId = this.dataset.prefeituraId;

                    // Esconde os cards
                    cardsContainer.classList.add('hidden');
                    btnVoltarContainer.classList.remove('hidden');

                    // Filtra os processos pela prefeitura clicada
                    document.querySelectorAll('tbody tr').forEach(row => {
                        if (row.querySelector('td').textContent.trim() === this
                            .querySelector('h3').textContent.trim()) {
                            row.classList.remove('hidden');
                        } else {
                            row.classList.add('hidden');
                        }
                    });
                });
            });

            btnVoltar.addEventListener('click', function() {
                cardsContainer.classList.remove('hidden');
                btnVoltarContainer.classList.add('hidden');

                // Mostra todas as linhas da tabela
                document.querySelectorAll('tbody tr').forEach(row => row.classList.remove('hidden'));
            });

        });
    </script>
@endsection
