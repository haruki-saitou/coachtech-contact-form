@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <main>
        @if (session('success'))
            <div class="form__success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="form__error">
                {{ session('error') }}
            </div>
        @endif

        <div class="login-form__content">
            <div class="login-form__heading">
                ログイン
            </div>
            <form action="/login" class="form" method="POST">
                @csrf
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="email" class="form__label">メールアドレス</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="email" name="email" id="email" class="form__input" value="{{ old('email') }}" />
                        @error('email')
                            <div class="form__error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="password" class="form__label">パスワード</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="password" name="password" id="password" class="form__input"
                            value="{{ old('password') }}" />
                        @error('password')
                            <div class="form__error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button type="submit" class="form__button--submit">ログイン</button>
                </div>
            </form>
        </div>
    </main>
@endsection
