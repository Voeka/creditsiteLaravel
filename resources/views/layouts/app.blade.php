<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KreditBank</title>
    @vite('resources/css/app.css') <!-- если используешь Tailwind через Vite -->
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl">KreditBank</h1>
            <nav>
                <a href="{{ url('/') }}" class="mr-4 hover:underline">Главная</a>
                @auth
                    <a href="{{ route('user.dashboard') }}" class="hover:underline">Личный кабинет</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Войти</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="bg-gray-200 text-gray-700 p-4 text-center">
        © {{ date('Y') }} KreditBank. Все права защищены.
    </footer>

    @vite('resources/js/app.js')
</body>
</html>
