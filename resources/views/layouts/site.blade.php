<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestGov</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        header: '#01464C',
                        body: '#145156',
                        button: '#03C173',
                        card: '#01464C',
                        accent: '#03C173',
                        verde: '#03C173',
                        primary: '#047a85',
                        'primary-light': '#0596A2',
                        secondary: '#FF6B35',
                        dark: '#2D3A3A',
                        light: '#F7F9F9',
                        gray: '#E5E7EB',
                        success: '#10B981',
                    },
                    container: {
                        center: true,
                        padding: {
                            DEFAULT: '1rem',
                            sm: '1.5rem',
                            md: '2rem',
                            lg: '3rem',
                            xl: '4rem',
                            '2xl': '12rem',
                        },
                    },
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .leaflet-container {
            z-index: 10;
        }

        .step-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 30px;
            counter-reset: step;
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            width: 100%;
            background-color: #e5e7eb;
            z-index: 1;
        }

        .progress-bar {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            height: 4px;
            background: linear-gradient(90deg, #0596A2, #047a85);
            z-index: 2;
            transition: width 0.5s ease;
        }

        .step {
            position: relative;
            z-index: 3;
            width: 40px;
            height: 40px;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #6b7280;
        }

        .step.active {
            background-color: #047a85;
            color: white;
        }

        .step.completed {
            background-color: #03C173;
            color: white;
        }

        .step-label {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            margin-top: 8px;
            font-size: 0.75rem;
            color: #6b7280;
            white-space: nowrap;
        }

        .step.active .step-label {
            color: #047a85;
            font-weight: 500;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            ring: 2px;
            ring-color: #0596A2;
            border-color: #0596A2;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen leading-relaxed text-gray-800 bg-body font-inter">

    <header class="py-4 shadow-md bg-header">
        <div class="flex items-center justify-between px-4 mx-auto sm:container">
            <div class="flex items-center">
                <img src="{{ asset('logos/logo.png') }}" alt="Cristino Castro Online" class="h-16 md:h-20">
            </div>

            <div>
                <a href="{{ route('admin.minhas-solicitacoes.index') }}"
                    class="flex items-center px-4 py-2 font-semibold text-white transition-colors rounded-lg shadow-md bg-button">
                    ACOMPANHAR SOLICITAÇÃO
                </a>

            </div>
        </div>
    </header>

    <main class="flex-grow py-8 md:py-12 bg-body">
        {{ $slot }}
    </main>

    <footer class="py-6 mt-auto text-center text-white bg-header">
        <div class="flex flex-col items-center gap-3 px-4 mx-auto sm:container">
            <p class="text-sm">&copy; {{ date('Y') }} Cristino Castro Online - Todos os direitos reservados</p>

            <div class="flex items-center gap-2">
                <span class="text-sm">Desenvolvido por</span>
                <a href="https://softsolucoes.tech/">
                    <img src="{{ url('logos/soft-branco.png') }}" alt="Logo Soft" class="h-6">
                </a>
            </div>
        </div>
    </footer>

</body>

</html>
