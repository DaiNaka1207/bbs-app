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
        // 全キャッシュのクリア
        // Cache::flush();
        // dd(Cache::get('user_name'));

        // ユーザー識別子をセッションに登録（なければランダムに生成）
        // if($request->session()->missing('user_identifier')){ session(['user_identifier' => Str::random(20)]); }
        Cache::add('user_identifier', Str::random(20));
        // dd(Cache::get('user_identifier'));
        
        // ユーザー名をセッションに登録（デフォルト値：Guest）
        if($request->session()->missing('user_name')){ session(['user_name' => 'Guest']); }
        Cache::add('user_name', 'Guest');
        // dd(Cache::get('user_name'));

        // スレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs/index', compact('threads'));
    }

    public function store(Request $request)
    {
        // フォームで入力されたユーザー名をセッションに登録
        // session(['user_name' => $request->user_name]);
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
