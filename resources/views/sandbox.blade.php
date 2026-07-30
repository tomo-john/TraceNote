<x-layouts.base>

    <div
        x-data="{ x: 0 }"
        class="max-w-5xl mx-auto border border-slate-200 rounded-2xl p-10 m-10"
    >

        <div>

            <i
                class="fa-solid fa-dog text-2xl text-pink-400"
                :style="`transform: translate(${x}px)`"
                style="transition: transform .3s ease;"
            ></i>

        </div>

        <button
            x-on:click="x -= 50"
            class="mt-5 px-4 py-2 bg-gray-500 text-white rounded-2xl"
        >
            左へ
        </button>

        <button
            x-on:click="x += 50"
            class="mt-5 px-4 py-2 bg-blue-500 text-white rounded-2xl"
        >
            右へ
        </button>

    </div>

</x-layouts.base>
