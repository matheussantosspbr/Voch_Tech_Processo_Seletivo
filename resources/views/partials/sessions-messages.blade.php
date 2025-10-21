@if (session()->has('error'))
    <div 
        x-data="{ show: true }" 
        x-show="show"
        class="mt-3 h-14 flex items-center justify-between gap-2 rounded-lg border-b-2 border-red-500 dark:bg-zinc-900 px-4 py-2 text-sm text-black dark:text-white shadow-sm"
    >
        <div class="flex items-center gap-2">
            {{ session('error') }}
        </div>

        <button @click="show = false" onclick="location.reload(true);" class="text-red-500 hover:text-red-700 transition text-lg cursor-pointer">
            ✕
        </button>
    </div>
@endif
