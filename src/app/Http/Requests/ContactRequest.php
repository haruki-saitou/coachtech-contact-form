<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContactRequest extends FormRequest
{
    /**
     * リクエストがこのアクションを許可されているか判断する。
     * 認証済みユーザーのみアクセス可能とするため true を返します。
     *
     * @return bool
     */
    public function authorize()
    {
        // 認証済みユーザーのみがこのリクエストを実行できるようにする
        return Auth::check();
    }

    /**
     * リクエストに適用されるバリデーションルールを取得する。
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // first_nameとlast_nameを結合せずに個別にバリデーション
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // 性別: 1(男性), 2(女性), 3(その他) のいずれか
            'gender' => ['required', 'in:1,2,3'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 電話番号はハイフンなしの数値で、10桁または11桁を想定
            'tel' => ['required', 'numeric', 'digits_between:10,11'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            // image_path はファイル移動後に null または文字列として保存されるため、ここではセッションの有無に依存する
            'image_path' => ['nullable', 'string'],
        ];
    }

    /**
     * バリデーションエラーメッセージを定義する。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gender.in' => '性別を選択してください。',
            'tel.numeric' => '電話番号は数値で入力してください。',
            'tel.digits_between' => '電話番号は10桁または11桁で入力してください。',
            'content.max' => 'お問い合わせ内容は1000文字以内で入力してください。',
            // その他の一般的なエラーメッセージはLaravelのデフォルトを使用
        ];
    }

    /**
     * 属性名（フィールド名）を定義する。
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => '名',
            'last_name' => '姓',
            'gender' => '性別',
            'email' => 'メールアドレス',
            'tel' => '電話番号',
            'address' => '住所',
            'building' => '建物名',
            'content' => 'お問い合わせ内容',
        ];
    }
}
