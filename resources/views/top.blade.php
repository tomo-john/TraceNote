<x-layouts.base>
    <div x-data="start()"
         class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-b from-slate-50 to-zinc-100 px-4"
    >

        <x-ui.card class="max-w-md w-full text-center space-y-8">

            <div class="space-y-3">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-lime-50 text-lime-500 p-5 rounded-2xl text-4xl">
                    <i class="fa-solid fa-tree"></i>
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

            <div class="flex flex-col items-center gap-4">

                <x-ui.button :href="route('login')" wire:navigate variant="primary" class="w-full sm:w-36">
                    <i class="fa-solid fa-right-to-bracket text-sm"></i>
                    ログイン
                </x-ui.button>

                <p class="text-sm font-medium text-slate-500">初めて利用しますか？</p>

                <x-ui.button :href="route('register')" wire:navigate variant="secondary" class="w-full sm:w-36">
                    <i class="fa-solid fa-user-plus text-sm"></i>
                    新規登録
                </x-ui.button>

            </div>

        </x-ui.card>

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
