<x-layouts.base>

    <div
        x-data="{ x: 0, dir: 1 }"
        class="space-y-6"
    >

        <div class="max-w-5xl mx-auto border border-slate-200 rounded-2xl p-10 m-10">

            <i
                class="fa-solid fa-dog text-2xl text-pink-400 transition-transform duration-300 ease-in-out"
                :style="`transform: translateX(${x}px) scaleX(${dir})`"
            ></i>

        </div>

        <div class="max-w-xl mx-auto flex items-center justify-center gap-2">
            <button
                x-on:click="x -= 50; dir = -1"
                class="px-4 py-2 bg-gray-500 text-white rounded-2xl"
            >
                左
            </button>

            <button
                x-on:click="x += 50; dir = 1"
                class="px-4 py-2 bg-blue-500 text-white rounded-2xl"
            >
                右
            </button>
        </div>

    </div>

</x-layouts.base>
