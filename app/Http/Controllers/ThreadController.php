<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        // ユーザー識別子をセッションに登録（なければランダムに生成）
        if($request->session()->missing('user_identifier')){ session(['user_identifier' => Str::random(20)]); }

        // ユーザー名をセッションに登録（なければGuestとして登録）
        if($request->session()->missing('user_name')){ session(['user_name' => 'Guest']); }

        // スレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs/index', compact('threads'));
    }

    public function store(Request $request)
    {
        // フォームで入力されたユーザー名をセッションに登録
        session(['user_name' => $request->user_name]);

        // フォームに入力されたスレッド情報をデータベースへ登録
        $threads = new Thread;
        $form = $request->all();
        $threads->fill($form)->save();

        // 掲示板ページへリダイレクト
        return redirect('/');
    }

    public function destroy($id)
    {
        // スレッド情報をデータベースから削除
        $thread = Thread::find($id)->delete();

        // 掲示板ページへリダイレクト
        return redirect('/');
    }

    public function search(Request $request)
    {
        // 検索フォームに入力された単語のエスケープ処理
        $search_message = '%' . addcslashes($request->search_message, '%_\\') . '%';

        // 検索フォームに入力された単語でLIKE検索した結果のスレッド情報を取得して代入（最新情報を上位に表示）
        $threads = Thread::where('message', 'LIKE', $search_message)->orderBy('created_at', 'desc')->Paginate(5);

        // 掲示板ページを表示
        return view('bbs/index', compact('threads'));
    }
}
