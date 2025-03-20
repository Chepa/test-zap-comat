<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Рандомная страница')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container">
    <header>
        <h1>Сайт для тестового задания</h1>
        <nav>
            <ul>
                <li><a href="{{ route('main') }}">Главная</a></li>
                <li><a href="{{ route('products.index') }}">Каталог</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© {{ date('Y') }} Тестовый сайт. Все права защищены. Удачи!</p>
    </footer>
</div>

</body>
</html>
