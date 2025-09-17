@extends('layouts.app')

@section('title', 'Dashboard - Licicon')

@section('content')
<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Cabeçalho -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Painel da Licicon</h2>
            <p class="mt-1 text-sm text-gray-500">Visão geral do sistema</p>
        </div>

        <!-- Cartões de Estatísticas -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
            <!-- Cartão Processos -->
            <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-700">Processos</h3>
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg">
                        <i class="text-blue-600 fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-[#0596A2]">1.248</p>
                    <p class="mt-1 text-sm text-gray-500">Total de processos</p>
                </div>
            </div>

            <!-- Cartão Prefeituras -->
            <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-700">Prefeituras</h3>
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg">
                        <i class="text-green-600 fas fa-building"></i>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-[#0596A2]">12</p>
                    <p class="mt-1 text-sm text-gray-500">Prefeituras cadastradas</p>
                </div>
            </div>
        </div>

        <!-- Lista de Processos Recentes -->
        <div class="overflow-hidden bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-medium text-gray-700">Processos Recentes</h3>
            </div>

            <div class="divide-y divide-gray-100">
                <!-- Processo 1 -->
                <div class="px-6 py-4 transition-colors hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Processo #2023-0001</p>
                            <p class="text-sm text-gray-500">Licença Ambiental - Prefeitura de Cristino Castro</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">Pendente</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="mr-1 text-xs far fa-clock"></i>
                            Criado em: 15/11/2023
                        </span>
                    </div>
                </div>

                <!-- Processo 2 -->
                <div class="px-6 py-4 transition-colors hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Processo #2023-0002</p>
                            <p class="text-sm text-gray-500">Alvará de Construção - Prefeitura de Cristino Castro</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Aprovado</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="mr-1 text-xs far fa-clock"></i>
                            Criado em: 14/11/2023
                        </span>
                    </div>
                </div>

                <!-- Processo 3 -->
                <div class="px-6 py-4 transition-colors hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Processo #2023-0003</p>
                            <p class="text-sm text-gray-500">IPTU - Prefeitura de Cristino Castro</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">Em análise</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="mr-1 text-xs far fa-clock"></i>
                            Criado em: 13/11/2023
                        </span>
                    </div>
                </div>

                <!-- Processo 4 -->
                <div class="px-6 py-4 transition-colors hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Processo #2023-0004</p>
                            <p class="text-sm text-gray-500">Alvará de Funcionamento - Prefeitura de Cristino Castro</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Rejeitado</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="mr-1 text-xs far fa-clock"></i>
                            Criado em: 12/11/2023
                        </span>
                    </div>
                </div>

                <!-- Processo 5 -->
                <div class="px-6 py-4 transition-colors hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">Processo #2023-0005</p>
                            <p class="text-sm text-gray-500">Licença Sanitária - Prefeitura de Cristino Castro</p>
                        </div>
                        <div class="flex items-center">
                            <span class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Aprovado</span>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        <span class="flex items-center">
                            <i class="mr-1 text-xs far fa-clock"></i>
                            Criado em: 10/11/2023
                        </span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                <a href="#" class="text-sm font-medium text-[#0596A2] hover:text-[#047a85] flex items-center justify-center">
                    Ver todos os processos
                    <i class="ml-2 text-xs fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
