@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
    <main class="thanks-body">
        <div class="thanks-container">

            <div class="thanks-icon">
                &#10003;
            </div>
            <h1 class="thanks-heading">
                お問い合わせありがとうございます！
            </h1>
            <p class="thanks-message">
                お問い合わせを送信しました。
            </p>

            <a href="{{ route('contacts.index') }}" class="thanks-button">
                ホームに戻る
            </a>
        </div>
    </main>
@endsection
