<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // ログインユーザーと紐付けるための外部キー (必須)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ★★★ 氏名（first_name と last_name に分割） ★★★
            $table->string('first_name', 255);
            $table->string('last_name', 255);

            // ★★★ 性別（gender）を追加 ★★★
            // 1: 男性, 2: 女性, 3: その他 を想定
            $table->unsignedTinyInteger('gender');

            $table->string('email', 255);

            // ★★★ 電話番号（tel）に変更 ★★★
            $table->string('tel', 20);

            // ★★★ 住所（address と building）を追加 ★★★
            $table->string('address', 255);
            $table->string('building', 255)->nullable(); // 建物名は任意のためnullable

            // お問い合わせ内容
            $table->text('content');

            // 画像パス (confirmで一時保存し、storeで永続化するパス)
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};