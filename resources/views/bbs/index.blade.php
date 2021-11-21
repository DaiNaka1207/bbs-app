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
            <form action="/" method="POST">
                @csrf
                <div class="flex">
                    <p class="font-bold">名前</p>
                    <input class="border rounded px-2 ml-2" type="text" name="user_name">
                </div>
                <div class="flex mt-2">
                    <p class="font-bold">件名</p>
                    <input class="border rounded px-2 ml-2 flex-auto" type="text" name="message_title">
                </div>
                <div class="flex flex-col mt-2">
                    <p class="font-bold">本文</p>
                    <textarea class="border rounded px-2" name="message"></textarea>
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
        <div class="bg-white rounded-md mt-1 mb-5 p-3">
            {{-- スレッド --}}
            <div>
                <p class="mb-2 text-xs">2021/11/20 18:00 ＠Noname</p>
                <p class="mb-2 text-xl font-bold">●●について</p>
                <p class="mb-2">これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。</p>
            </div>
            {{-- 削除ボタン --}}
            <form class="flex justify-end mt-5" action="/" method="POST">
                @csrf
                <input class="border rounded px-2 flex-auto" type="text" name="reply_message">
                <input class="px-2 py-1 ml-2 rounded bg-green-600 text-white font-bold link-hover cursor-pointer" type="submit" value="返信">
                <input class="px-2 py-1 ml-2 rounded bg-red-500 text-white font-bold link-hover cursor-pointer" type="submit" value="削除">
            </form>
            {{-- 返信 --}}
            <hr class="mt-2 m-auto">
            <div class="flex justify-end">
                <div class="w-11/12">
                    <div>
                        <p class="mt-2 text-xs">2021/11/20 19:00 ＠Noname</p>
                        <p class="my-2 text-sm">これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 投稿 --}}
        <div class="bg-white rounded-md mt-1 mb-1 p-3">
            {{-- スレッド --}}
            <div>
                <p class="mb-2 text-xs">2021/11/20 18:00 ＠Noname</p>
                <p class="mb-2 text-xl font-bold">●●について</p>
                <p class="mb-2">これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。これは本文です。</p>
            </div>
            {{-- 削除ボタン --}}
            <form class="flex justify-end mt-5" action="/" method="POST">
                @csrf
                <input class="border rounded px-2 flex-auto" type="text" name="reply_message">
                <input class="px-2 py-1 ml-2 rounded bg-green-600 text-white font-bold link-hover cursor-pointer" type="submit" value="返信">
                <input class="px-2 py-1 ml-2 rounded bg-red-500 text-white font-bold link-hover cursor-pointer" type="submit" value="削除">
            </form>
            {{-- 返信 --}}
            <hr class="mt-2 m-auto">
            <div class="flex justify-end">
                <div class="w-11/12">
                    <div>
                        <p class="mt-2 text-xs">2021/11/20 19:00 ＠Noname</p>
                        <p class="my-2 text-sm">これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。</p>
                    </div>
                    <hr class="mt-2 m-auto">
                    <div>
                        <p class="mt-2 text-xs">2021/11/20 19:00 ＠Noname</p>
                        <p class="my-2 text-sm">これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。これは返信です。</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ページネーション --}}
        <p class="flex justify-center text-blue-300 mt-1 mb-5 link-hover cursor-pointer">prev 1 2 3 4 next</p>
    </div>
</body>
</html>