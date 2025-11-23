<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可する属性。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        // 氏名、性別、電話番号、住所系のカラム
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel', // 'phone_number' から 'tel' に変更
        'address',
        'building', // 建物名・部屋番号など
        'content', // お問い合わせ内容
        'image_path', // 画像パス
    ];

    /**
     * このお問い合わせに紐づくユーザーを取得します。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
