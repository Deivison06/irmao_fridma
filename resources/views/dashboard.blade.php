<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Painel da Prefeitura</h2>
                <p class="mt-1 text-sm text-gray-500">Visão geral e ações rápidas do sistema</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Cartões de Estatísticas -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                <!-- Cartão Notícias -->
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-base font-medium text-gray-700">Serviços Onlines</h3>
                    </div>
                    <div class="px-6 py-8 text-center">
                        <p class="text-4xl font-bold text-[#0596A2]"> top </p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Ativos
                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-3 text-center border-t border-gray-100 bg-gray-50">
                        <a href="#" class="text-sm font-medium text-[#0596A2] hover:text-[#047a85]">
                            Ver todas
                        </a>
                    </div>
                </div>

                <!-- Cartão Acessos Rápidos -->
                <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-base font-medium text-gray-700">Card Solicitações</h3>
                    </div>
                    <div class="px-6 py-8 text-center">
                        <p class="text-4xl font-bold text-[#0596A2]">Card</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3" />
                                </svg>
                                Ativos
                            </span>
                        </div>
                    </div>
                    <div class="px-6 py-3 text-center border-t border-gray-100 bg-gray-50">
                        <a href="#" class="text-sm font-medium text-[#0596A2] hover:text-[#047a85]">
                            Gerenciar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="mb-6 overflow-hidden bg-white shadow-sm rounded-xl">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Ações Rápidas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <a href="#"
                           class="flex flex-col items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50 group">
                            <div class="flex items-center justify-center w-12 h-12 mb-3 text-white bg-[#0596A2] rounded-lg group-hover:bg-[#047a85]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-center text-gray-700">Novo Serviço Online</span>
                        </a>

                        <a href="#"
                           class="flex flex-col items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50 group">
                            <div class="flex items-center justify-center w-12 h-12 mb-3 text-white bg-[#0596A2] rounded-lg group-hover:bg-[#047a85]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-center text-gray-700">Gerenciar Serviços Online</span>
                        </a>

                        <a href="#"
                           class="flex flex-col items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50 group">
                            <div class="flex items-center justify-center w-12 h-12 mb-3 text-white bg-[#0596A2] rounded-lg group-hover:bg-[#047a85]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-center text-gray-700">Nova Solicitação</span>
                        </a>

                        <a href="#"
                            class="flex flex-col items-center p-4 transition-colors border border-gray-200 rounded-lg hover:bg-gray-50 group">
                            <div class="flex items-center justify-center w-12 h-12 mb-3 text-white bg-[#0596A2] rounded-lg group-hover:bg-[#047a85]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-center text-gray-700">Gerenciar Solicitações</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
