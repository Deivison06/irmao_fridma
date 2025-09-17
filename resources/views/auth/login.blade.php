<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-white">E-mail</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="email"
                class="w-full px-4 py-3.5 rounded-lg bg-white bg-opacity-95 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 shadow-sm transition-all duration-300 focus:-translate-y-0.5">
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-white">Senha</label>
            <input type="password" id="password" name="password" required autocomplete="current-password"
                class="w-full px-4 py-3.5 rounded-lg bg-white bg-opacity-95 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 shadow-sm transition-all duration-300 focus:-translate-y-0.5">
        </div>

        <!-- Remember Me -->
        <div class="flex flex-wrap items-center justify-between mt-6">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox"
                    class="w-4 h-4 mr-2 text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                    name="remember">
                <label for="remember_me" class="text-sm text-white">Lembrar-me</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-sm text-white hover:text-[#FF9E1F] hover:underline transition-colors duration-300">
                    Esqueci minha senha
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full bg-[#FF9E1F] hover:bg-[#FF8A00] text-white font-semibold py-3.5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-orange-300">
            Entrar
        </button>
    </form>
</x-guest-layout>
