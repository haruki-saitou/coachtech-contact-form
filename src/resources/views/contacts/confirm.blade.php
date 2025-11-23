@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
    <main>
        <div class="confirm-container">
            <div class="confirm-heading">
                お問い合わせ内容の確認
            </div>

            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf
                <table class="confirm-table">
                    <tr>
                        <th>お名前</th>
                        <td>{{ $input['last_name'] }} {{ $input['first_name'] }}</td>
                    </tr>
                    <tr>
                        <th>性別</th>
                        <td>{{ $input['gender'] == 1 ? '男性' : '女性' }}</td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>{{ $input['email'] }}</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>{{ $input['tel'] }}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>{{ $input['address'] }}</td>
                    </tr>
                    <tr>
                        <th>建物名</th>
                        <td>{{ $input['building'] ?? '（未入力）' }}</td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>{{ $input['content'] }}</td>
                    </tr>
                    <tr>
                        <th>添付ファイル</th>
                        <td>
                            <!-- ★ 修正点: Base64データがあれば画像を表示 -->
                            @if (isset($input['image_base64']))
                                <img src="{{ $input['image_base64'] }}" alt="添付画像" class="confirm-image">
                            @else
                                （添付ファイルなし）
                            @endif
                            <!-- 画像の本パスはセッションに隠して保持するため、フォームには含めません -->
                        </td>
                    </tr>
                </table>

                <div class="confirm-actions">
                    <button type="submit" class="confirm-button">送信</button>

                    <!-- 戻るボタンは GET リクエストに見せかけて POST し、セッションデータを保持したまま戻ります -->
                    <button type="submit" name="back" value="1" class="back-link">
                        修正する
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
