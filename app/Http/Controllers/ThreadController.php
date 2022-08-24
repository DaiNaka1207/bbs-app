<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        // Cookieを変数に読み込み
        $user = [
            'name' => $request->cookie('bbs-app_name'),
            'identifier' => $request->cookie('bbs-app_identifier'),
        ];

        // Cookieが存在しなければデフォルト値を設定
        if ($user['name'] === null) {
            
            $user = [
                'name' => 'Guest',
                'identifier' => Str::random(20),
            ];

            Cookie::queue('bbs-app_name', $user['name']);
            Cookie::queue('bbs-app_identifier', $user['identifier']);
        }

        // スレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs/index', compact('threads', 'user'));
    }

    public function store(Request $request)
    {
        // フォームで入力されたユーザー名をキャッシュに登録
        Cookie::queue('bbs-app_name', $request->user_name);

        // フォームに入力されたスレッド情報をデータベースへ登録
        $threads = new Thread;
        $form = $request->all();
        $threads->fill($form)->save();

        // 掲示板ページへリダイレクト
        return redirect(route('home'));
    }

    public function destroy($id)
    {
        // スレッド情報をデータベースから削除
        $thread = Thread::find($id)->delete();

        // 掲示板ページへリダイレクト
        return redirect(route('home'));
    }

    public function search(Request $request)
    {
        // 検索フォームに入力された単語のエスケープ処理
        $search_message = '%' . addcslashes($request->search_message, '%_\\') . '%';

        // 検索フォームに入力された単語でLIKE検索した結果のスレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::where('message', 'LIKE', $search_message)->orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs.index', compact('threads'));
    }
}
