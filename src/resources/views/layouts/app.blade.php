<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせフォーム</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('contacts.index') }}" class="header__inner-logo">
                お問い合わせフォーム
            </a>
            <nav class="header-nav">
                <ul class="header-nav__list">
                    @if (Auth::check())
                        <li class="header-nav__item">
                            <a href="{{ route('contacts.history') }}" class="header-nav__link">
                                送信履歴
                            </a>
                        </li>
                        <li class="header-nav__item">
                            <form action="/logout" method="POST">
                                @csrf
                                <button class="header-nav__button">ログアウト</button>
                            </form>
                        </li>
                    @endif
                    @guest
                        @if (!Route::is('login'))
                            <li class="header-nav__item">
                                <a href="{{ route('login') }}" class="header-nav__link">ログイン</a>
                            </li>
                        @endif
                        @if (!Route::is('register'))
                            <li class="header-nav__item">
                                <a href="{{ route('register') }}" class="header-nav__link">新規登録</a>
                            </li>
                        @endif
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>
