<x-layouts.base>
    <div x-data="start()"
         class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-b from-slate-50 to-zinc-100 px-4"
    >

        <div class="max-w-md w-full bg-white/80 backdrop-blur-md border border-slate-100
                    p-8 rounded-3xl shadow-xl shadow-slate-200/50 text-center space-y-8
                    transition-all duration-500 hover:shadow-2xl"
        >

            <div class="space-y-3">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-sky-100 text-sky-600 p-5 rounded-2xl text-4xl">
                    <i class="fa-solid fa-dog"></i>
                </div>

                <h1 class="text-4xl font-extrabold tracking-tight text-slate-800">
                    Trace Note
                </h1>

                <p class="text-sm font-medium text-slate-500 max-w-xs mx-auto leading-relaxed">
                    学んだ痕跡を、<br>
                    自分だけの知識として積み重ねる。
                </p>
            </div>

            <hr class="border-dashed border-slate-200">

            <div class="flex flex-col gap-3 sm:flex-row sm:justify-center sm:gap-4">
                <a href="{{ route('login') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center gap-2 w-full sm:w-36
                          bg-slate-400 text-white font-bold rounded-xl py-3 px-5
                          hover:bg-slate-500 active:scale-95 transition shadow-sm shadow-slate-200"
                >
                    <i class="fa-solid fa-right-to-bracket text-sm"></i>
                    <span>ログイン</span>
                </a>

                <a href="{{ route('register') }}"
                   wire:navigate
                   class="inline-flex items-center justify-center gap-2 w-full sm:w-36 bg-slate-100 text-slate-600 font-bold rounded-xl py-3 px-5 hover:bg-slate-200 active:scale-95 transition"
                >
                    <i class="fa-solid fa-user-plus text-sm"></i>
                    <span>新規登録</span>
                </a>
            </div>

        </div>

    </div>

    <script>
        function start() {
            return {
                init() {
                    console.log('Trace Note Start 🐶🐾');
                }
            }
        }
    </script>
</x-layouts.base>
