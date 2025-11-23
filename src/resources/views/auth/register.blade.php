@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
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
        <div class="register-form__content">
            <div class="register-form__heading">
                会員登録
            </div>
            <form action="/register" class="form" method="POST">
                @csrf
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="name" class="form__label">名前</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="text" name="name" id="name" class="form__input" value="{{ old('name') }}" />
                        @error('name')
                            <div class="form__error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
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
                        <label for="phone_number" class="form__label">電話番号</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="tel" name="phone_number" id="phone_number" class="form__input"
                            value="{{ old('phone_number') }}" />
                        @error('phone_number')
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
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="password_confirmation" class="form__label">確認用パスワード</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form__input"
                            value="{{ old('password_confirmation') }}" />
                        @error('password_confirmation')
                            <div class="form__error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button type="submit" class="form__button--submit">登録</button>
                </div>
            </form>
        </div>
    </main>
@endsection
