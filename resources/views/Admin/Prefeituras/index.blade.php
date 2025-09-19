@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Lista de Prefeituras</h2>
            <p class="mt-1 text-sm text-gray-500">Gerencie as prefeituras cadastradas</p>
        </div>
        <a href="{{ route('admin.prefeituras.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-[#009496] rounded-lg hover:bg-[#244853] transition-colors shadow-sm">
            Nova Prefeitura
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 mb-6 rounded-lg bg-green-50">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="overflow-hidden bg-white shadow-sm rounded-xl">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-700">Prefeituras Cadastradas</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Nome</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">CNPJ</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Telefone</th>
                        <th class="px-6 py-3 text-xs font-medium text-center text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($prefeituras as $prefeitura)
                        <tr>
                            <td class="px-6 py-4">{{ $prefeitura->nome }}</td>
                            <td class="px-6 py-4">{{ $prefeitura->cnpj }}</td>
                            <td class="px-6 py-4">{{ $prefeitura->email }}</td>
                            <td class="px-6 py-4">{{ $prefeitura->telefone }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.prefeituras.edit', $prefeitura->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin.prefeituras.destroy', $prefeitura->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Excluir prefeitura?')" class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
