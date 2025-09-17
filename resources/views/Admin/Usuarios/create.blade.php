@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="py-6">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Meu Perfil</h2>
            <p class="mt-1 text-sm text-gray-500">Gerencie suas informações de perfil e segurança</p>
        </div>

        <div class="space-y-6">
            <!-- Atualizar Informações do Perfil -->
            <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Informações do Perfil</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Atualizar Senha -->
            <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Alterar Senha</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Excluir Conta -->
            <div class="overflow-hidden bg-white shadow-sm rounded-xl">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-700">Excluir Conta</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
