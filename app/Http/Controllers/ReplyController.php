<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        // フォームに入力されたリプライ情報をデータベースへ登録
        $replies = new Reply;
        $form = $request->all();
        $replies->fill($form)->save();

        // 掲示板ページへリダイレクト
        return redirect('/');
    }
}
