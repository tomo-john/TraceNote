<x-layouts.base>
    <div x-data="start()">

        <div class="flex items-center justify-center gap-1 m-10">
            <h1 class="text-xl font-bold text-slate-500">
                <i class="fa-solid fa-dog"></i>
                Trace Note
            </h1>
        </div>

        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('login') }}"
               class="inline-block w-28 text-center bg-amber-400 text-white rounded-lg py-2 px-5 hover:bg-amber-500 transition"
            >
                ログイン
            </a>
            <a href="{{ route('register') }}"
               class="inline-block w-28 text-center bg-slate-400 text-white rounded-lg py-2 px-5 hover:bg-slate-500 transition"
            >
                新規登録
            </a>
        </div>
    </div>

    <script>
        function start() {
            return {
                init() {
                    console.log('test');
                }
            }
        }
    </script>
</x-layouts.base>
