<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        // ユーザー識別子をキャッシュに登録（なければランダムに生成）
        Cache::add('user_identifier', Str::random(20));
        
        // ユーザー名をキャッシュに登録（デフォルト値：Guest）
        Cache::add('user_name', 'Guest');

        // スレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs/index', compact('threads'));
    }

    public function store(Request $request)
    {
        // フォームで入力されたユーザー名をキャッシュに登録
        Cache::put('user_name', $request->user_name);

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
