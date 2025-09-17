<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Licicon - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#244853]">

    <div class="flex items-center justify-center min-h-screen px-4">
            <div class="w-full max-w-md p-8 bg-[#009496] shadow-xl rounded-2xl">
            <div class="flex justify-center mb-6">
                <div style="padding: 1.2rem;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease">
                    <a href="/">
                        <img src="{{ url('logo/logo_licicon.png') }}" alt="" class="w-64 h-auto">
                    </a>
                </div>
            </div>

            {{ $slot }}
        </div>
    </div>

</body>
</html>
