@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
@endsection

@section('content')
    <main>
        <div class="history-container">
            <h1 class="history-heading">
                お問い合わせ履歴一覧
            </h1>

            @if ($contacts->isEmpty())
                <div class="no-contacts">
                    まだお問い合わせ履歴はありません。
                </div>
            @else
                <ul class="contact-list">
                    @foreach ($contacts as $contact)
                        <li class="contact-item">
                            <div class="contact-meta">
                                <span class="contact-id">
                                    <span class="contact-details">ID:</span> {{ $contact->id }}
                                </span>
                                <span class="contact-date">
                                    <span class="contact-details">日時:</span> {{ $contact->created_at->format('Y/m/d H:i') }}
                                </span>
                            </div>

                            <div class="contact-meta">
                                <span class="contact-name">
                                    <span class="contact-details">お名前:</span> {{ $contact->last_name }} {{ $contact->first_name }}
                                </span>
                                <span class="contact-email">
                                    <span class="contact-details">メール:</span> {{ $contact->email }}
                                </span>
                            </div>

                            <!-- お問い合わせ内容のプレビュー -->
                            <p class="contact-content">
                                {{ $contact->content }}
                            </p>

                            @if ($contact->image_path)
                                <a href="{{ Storage::url($contact->image_path) }}" target="_blank" class="contact-image-link">
                                    添付ファイルを表示
                                </a>
                            @endif

                            <!-- 詳細表示や編集ボタン（必要に応じて実装） -->
                            <div class="contact-actions" style="margin-top: 15px;">
                                {{--
                                <a href="{{ route('contacts.show', $contact->id) }}" class="history-button">詳細を見る</a>
                                --}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </main>
@endsection
