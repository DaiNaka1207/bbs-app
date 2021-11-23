<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('app_name') }}</title>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        .link-hover:hover {opacity: 70%;}
    </style>
</head>
<body class="bg-blue-100">
    <div class="w-11/12 max-w-screen-md m-auto">

        {{-- タイトル --}}
        <h1 class="text-xl font-bold mt-5">{{ env('app_name') }}</h1>

        {{-- 入力フォーム --}}
        <div class="bg-white rounded-md mt-5 p-3">
            <form action="{{route('thread.store')}}" method="POST">
                @csrf
                <div class="flex">
                    <p class="font-bold">名前</p>
                    <input class="border rounded px-2 ml-2" type="text" name="user_name" required>
                </div>
                <div class="flex mt-2">
                    <p class="font-bold">件名</p>
                    <input class="border rounded px-2 ml-2 flex-auto" type="text" name="message_title" required>
                </div>
                <div class="flex flex-col mt-2">
                    <p class="font-bold">本文</p>
                    <textarea class="border rounded px-2" name="message" required></textarea>
                </div>
                <div class="flex justify-end mt-2">
                    <input class="my-2 px-2 py-1 rounded bg-blue-300 text-blue-900 font-bold link-hover cursor-pointer" type="submit" value="投稿">
                </div>
            </form>
        </div>

        {{-- 検索フォーム --}}
        <div class="bg-white rounded-md mt-3 p-3">
            <form action="/" method="post">
                @csrf
                <div class="mx-1 flex">
                    <input class="border rounded px-2 flex-auto" type="text" name="serch_message">
                    <input class="ml-2 px-2 py-1 rounded bg-gray-500 text-white font-bold link-hover cursor-pointer" type="submit" value="検索">
                </div>
            </form>
        </div>

        {{-- ページネーション --}}
        <p class="flex justify-center text-blue-300 mt-5 link-hover cursor-pointer">prev 1 2 3 4 next</p>

        {{-- 投稿 --}}
        @foreach ($threads as $thread)
            <div class="bg-white rounded-md mt-1 mb-5 p-3">
                {{-- スレッド --}}
                <div>
                    <p class="mb-2 text-xs">{{$thread->created_at}} ＠{{$thread->user_name}}</p>
                    <p class="mb-2 text-xl font-bold">{{$thread->message_title}}</p>
                    <p class="mb-2">{{$thread->message}}</p>
                </div>
                {{-- ボタン --}}
                <div class="flex mt-5">
                    {{-- 返信 --}}
                    <form class="flex justify-end flex-auto" action="{{route('reply.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="thread_id" value={{$thread->id}}>
                        <input class="border rounded px-2 flex-initial" type="text" name="user_name" placeholder="UserName" required>
                        <input class="border rounded px-2 ml-2 flex-auto" type="text" name="message" placeholder="ReplyMessage" required>
                        <input class="px-2 py-1 ml-2 rounded bg-green-600 text-white font-bold link-hover cursor-pointer" type="submit" value="返信">
                    </form>
                    {{-- 削除 --}}
                    <form action="{{route('thread.destroy', ['thread'=>$thread->id])}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input class="px-2 py-1 ml-2 rounded bg-red-500 text-white font-bold link-hover cursor-pointer" type="submit" value="削除" onclick="return Check()">
                    </form>
                </div>
                {{-- リプライ --}}
                <hr class="mt-2 m-auto">
                <div class="flex justify-end">
                    <div class="w-11/12">
                        @foreach ($thread->replies as $reply)
                            <div>
                                <p class="mt-2 text-xs">{{$reply->created_at}} ＠{{$reply->user_name}}</p>
                                <p class="my-2 text-sm">{{$reply->message}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        {{-- ページネーション --}}
        <p class="flex justify-center text-blue-300 mt-1 mb-5 link-hover cursor-pointer">prev 1 2 3 4 next</p>
    </div>

    {{-- スレッド削除の確認 --}}
    <script type="text/javascript">
        function Check(){
            var checked = confirm("本当に削除しますか？");
            if (checked == true) { return true; } else { return false; }
        }
    </script>
</body>
</html>