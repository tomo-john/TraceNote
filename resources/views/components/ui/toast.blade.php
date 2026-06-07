<div x-data="toast()"
     x-init="
        @if(session()->has('toast'))
            notify(@js(session('toast')))
        @endif
     "
     x-cloak
     x-show="show"
     x-on:notify.window="notify($event.detail)"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-2"
     class="fixed top-30 right-10 z-50 px-5 py-3 rounded-2xl
            backdrop-blur-md border border-pink-100 shadow-xl shadow-pink-100/40
            text-white font-bold flex items-center gap-2
            animate-[wiggle_0.3s_ease-in-out]"
     :class="bgClass"
>
    <i :class="iconClass"></i>
    <span x-text="message"></span>
</div>

<script>
    function toast() {
        return {
            show: false,
            message: '',
            type: 'success',
            timer: null,

            notify(detail) {
                this.message = detail.message;
                this.type = detail.type || 'success';
                this.show = true;

                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    this.show = false;
                }, 3000);
            },

            get bgClass() {
                return {
                    'bg-pink-400/90': this.type === 'success',
                    'bg-rose-400/90': this.type === 'danger',
                    'bg-pink-300/90': this.type === 'info',
                };
            },

            get iconClass() {
                return {
                    'fa-solid fa-dog': this.type === 'success',
                    'fa-solid fa-bomb': this.type === 'danger',
                    'fa-solid fa-circle-exclamation': this.type === 'info',
                };
            },
        }
    }
</script>
