<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * お問い合わせフォーム表示
     */
    public function index()
    {
        // 完了画面の表示は contacts.thanks に分離されているため、
        // index ビューを表示するのみ
        return view('contacts.index');
    }

    /**
     * お問い合わせ内容確認
     */
    public function confirm(Request $request)
    {
        $rules = [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'gender' => 'required|integer|in:1,2',
            'email' => 'required|email|max:255',
            'tel' => 'required|string|regex:/^[0-9]+$/|max:20',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB
        ];

        $input = $request->validate($rules);

        // 画像ファイルが存在する場合、Base64データと一時パスを両方取得
        if ($request->hasFile('image_file') && $request->file('image_file')->isValid()) {
            // 1. ファイルを一時ディレクトリ 'temp' に保存し、そのパスを取得
            $tempPath = $request->file('image_file')->store('temp');
            $input['image_path'] = $tempPath;

            // 2. Base64データを生成し、セッションに保存 (確認画面での表示用)
            $mimeType = $request->file('image_file')->getClientMimeType();
            $base64Data = base64_encode(Storage::get($tempPath));
            $input['image_base64'] = "data:{$mimeType};base64,{$base64Data}";

            // UploadedFileインスタンスはセッションに保存できないため unset
            unset($input['image_file']);
        } else {
             // 戻るボタンで戻ってきた際に Base64 データが残っている場合を考慮し、
             // Base64 データと一時パスを old() から取得し直す
            $oldInput = $request->session()->get('contact_input', []);
            // old() データから必要なフィールドを復元
            if ($request->input('back') && isset($oldInput['image_path']) && Storage::exists($oldInput['image_path'])) {
                $input['image_path'] = $oldInput['image_path'];
                $input['image_base64'] = $oldInput['image_base64'];
            }
        }

        $request->session()->put('contact_input', $input);

        return view('contacts.confirm', ['input' => $input]);
    }

    /**
     * お問い合わせ内容送信（データベース保存）
     */
    public function store(Request $request)
    {
        // セッションからデータを取得
        $input = $request->session()->get('contact_input');

        // 戻るボタンが押された場合（確認画面からの戻り）
        if ($request->input('back')) {
            // セッションデータを保持したまま入力画面に戻す
            return redirect()->route('contacts.index')->withInput($input);
        }

        if (!$input) {
            return redirect()->route('contacts.index')->withErrors(['error' => 'セッションの有効期限が切れました。最初から入力し直してください。']);
        }

        try {
            $contactData = [
                'last_name' => $input['last_name'],
                'first_name' => $input['first_name'],
                'gender' => $input['gender'],
                'email' => $input['email'],
                'tel' => $input['tel'],
                'address' => $input['address'],
                'building' => $input['building'] ?? null,
                'content' => $input['content'],
                'user_id' => Auth::id(),
            ];

            // 画像ファイルの本保存処理
            if (isset($input['image_path'])) {
                $tempFilePath = storage_path('app/' . $input['image_path']);

                if (Storage::exists($input['image_path'])) {
                    // 一時ファイルを 'public' ディスクの 'contacts' フォルダに移動
                    // Storage::putFile('contacts', new File($tempFilePath)) は自動でファイル名を生成します
                    $newPath = Storage::disk('public')->putFile('contacts', new File($tempFilePath));
                    $contactData['image_path'] = $newPath;

                    // 一時ファイルを削除
                    Storage::delete($input['image_path']);
                }
            }

            Contact::create($contactData);

            // データベース保存成功後、セッションデータをクリアする
            $request->session()->forget('contact_input');

            // ★ 修正点: 完了画面へリダイレクトする。ルート名 'contacts.thanks' を指定。
            return redirect()->route('contacts.thanks'); // ★ thanks に戻す

        } catch (\Exception $e) {
            Log::error("データベース保存エラー: " . $e->getMessage());
            // エラー時にも一時ファイルを削除
            if (isset($input['image_path'])) {
                Storage::delete($input['image_path']);
            }
            // セッションデータをクリアすることで、再試行時にゴミデータが残らないようにする
            $request->session()->forget('contact_input');

            return redirect()->route('contacts.index')->withErrors(['db_error' => 'お問い合わせの送信中にエラーが発生しました。再度入力してください。']);
        }
    }

    /**
     * お問い合わせ完了画面表示
     * (メソッド名を thanks に戻す)
     */
    public function thanks() // ★ thanks に戻す
    {
        // contacts.thanks ビューを表示
        return view('contacts.thanks');
    }

    /**
     * お問い合わせ履歴一覧表示
     */
    public function history()
    {
        // ★ 認証済みユーザーのお問い合わせ履歴を取得
        $contacts = Contact::where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->get();

        // ビューにデータを渡して表示
        return view('contacts.history', compact('contacts'));
    }
}
