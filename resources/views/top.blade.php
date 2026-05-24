<x-layouts.base>
    <div x-data="start()">
        <i class="fa-solid fa-dog"></i>
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
