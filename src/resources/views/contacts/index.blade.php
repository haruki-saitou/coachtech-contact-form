@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <main>
        <div class="contact-form__content">

            {{-- 成功メッセージとエラーメッセージの表示 --}}
            @if (session('success'))
                <div class="form__success">
                    {{ session('success') }}
                </div>
            @elseif ($errors->has('error') || $errors->has('db_error'))
                <div class="form__error">
                    {{ $errors->first('error') ?? $errors->first('db_error') }}
                </div>
            @endif

            <div class="contact-form__heading">
                お問い合わせ
            </div>

            {{-- enctype="multipart/form-data" を忘れずに --}}
            <form action="{{ route('contacts.confirm') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 氏名 (姓・名) フィールド -->
                <div class="form__group">
                    <div class="form__group--title">
                        <label class="form__label">お名前</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input name-fields" style="display: flex; gap: 20px;">
                        {{-- 姓 (last_name) --}}
                        <div style="flex: 1;">
                            <input type="text" name="last_name" placeholder="例: 山田 (姓)" class="form__input"
                                value="{{ old('last_name') }}">
                            @error('last_name')
                                <div class="form__error-message">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- 名 (first_name) --}}
                        <div style="flex: 1;">
                            <input type="text" name="first_name" placeholder="例: 太郎 (名)" class="form__input"
                                value="{{ old('first_name') }}">
                            @error('first_name')
                                <div class="form__error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- 性別 (gender) フィールド -->
                <div class="form__group">
                    <div class="form__group--title">
                        <label class="form__label">性別</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input gender-radio" style="display: flex; gap: 20px;">
                        <label>
                            <input type="radio" name="gender" value="1"
                                {{ old('gender', '1') == '1' ? 'checked' : '' }}> 男性
                        </label>
                        <label>
                            <input type="radio" name="gender" value="2"
                                {{ old('gender') == '2' ? 'checked' : '' }}> 女性
                        </label>
                        @error('gender')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="email" class="form__label">メールアドレス</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="email" name="email" id="email" class="form__input"
                            placeholder="例: test@example.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="tel" class="form__label">電話番号</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="tel" name="tel" id="tel" class="form__input" placeholder="例: 09012345678"
                            value="{{ old('tel') }}">
                        @error('tel')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                        <div class="form__example-message">
                            ※ハイフンなしで入力してください
                        </div>
                    </div>
                </div>

                <!-- 住所 (address) フィールド -->
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="address" class="form__label">住所</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <input type="text" name="address" id="address" class="form__input"
                            placeholder="例: 東京都渋谷区〇〇1-2-3" value="{{ old('address') }}">
                        @error('address')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 建物名 (building) フィールド -->
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="building" class="form__label">建物名</label>
                    </div>
                    <div class="form__group--input">
                        <input type="text" name="building" id="building" class="form__input"
                            placeholder="例: 〇〇ビル 101号室 (任意)" value="{{ old('building') }}">
                        @error('building')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group--title">
                        <label for="content" class="form__label">お問い合わせ内容</label>
                        <span class="form__label--required">必須</span>
                    </div>
                    <div class="form__group--input">
                        <textarea name="content" id="content" class="form__input" cols="30" rows="5"
                            placeholder="具体的なお問い合わせ内容をご記入ください">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 添付ファイルフィールド --}}
                <div class="form__group">
                    <div class="form__group--title">
                        <label for="image_file" class="form__label">添付ファイル（任意）</label>
                    </div>
                    <div class="form__group--input">
                        <input type="file" name="image_file" id="image_file" class="form__input--file"
                            accept="image/*">
                        @error('image_file')
                            <div class="form__error-message">{{ $message }}</div>
                        @enderror
                        {{-- プレビュー表示エリア --}}
                        <div class="image-preview__area"
                            style="margin-top: 10px; border: 1px dashed #ccc; padding: 10px; text-align: center; border-radius: 5px; background-color: #f9f9f9;">
                            <img id="image_preview" src="#" alt="選択中の画像"
                                style="max-width: 100%; max-height: 200px; display: none; object-fit: contain;">
                            <p id="preview_text" style="color: #888; margin: 0; padding: 0;">画像を選択してください</p>
                        </div>
                    </div>
                </div>

                <div class="form__button">
                    <button type="submit" class="form__button--submit">確認画面へ</button>
                </div>
            </form>
        </div>
    </main>

    {{-- 画像プレビュー用のJavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('image_file');
            const previewImage = document.getElementById('image_preview');
            const previewText = document.getElementById('preview_text');

            if (!fileInput || !previewImage || !previewText) {
                // コンソールにエラーを出力するのみ
                return;
            }

            // ページロード時、old()値でリダイレクトされた場合、画像情報をリセット
            // old()にファイル情報が残らないため、プレビューをクリアした状態にする
            if (fileInput.files.length === 0) {
                previewImage.style.display = 'none';
                previewText.style.display = 'block';
            }


            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    // ファイルサイズチェック (2MB) - バリデーションエラーとは別にクライアント側でもチェック
                    if (file.size > 2048 * 1024) {
                        alert('ファイルサイズが2MBを超えています。'); // 本番環境ではカスタムモーダルを使用
                        fileInput.value = ''; // 選択をクリア
                        previewImage.style.display = 'none';
                        previewText.style.display = 'block';
                        return;
                    }

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewText.style.display = 'none';
                    };

                    reader.readAsDataURL(file);

                } else {
                    previewImage.style.display = 'none';
                    previewImage.src = '#';
                    previewText.style.display = 'block';
                }
            });
        });
    </script>
@endsection
