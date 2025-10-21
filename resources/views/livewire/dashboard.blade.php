
<x-slot:title>Dashboard</x-slot:title>
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    
    <div class="grid auto-rows-min gap-4 md:grid-cols-4">
        <div class="relative aspect-video overflow-hidden rounded-xl border flex border-neutral-200 bg-[hsl(114,100%,50%)] dark:border-neutral-700 items-center justify-center">
            <div class="w-full h-[98%] rounded-xl flex flex-col items-center justify-center bg-white dark:bg-[#262626]">
                <h4>Grupos Econômicos</h4>
                <p>{{$gruposEconomicos}}</p>
            </div>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border flex border-neutral-200 bg-[hsl(114,100%,50%)] dark:border-neutral-700 items-center justify-center">
            <div class="w-full h-[98%] rounded-xl flex flex-col items-center justify-center bg-white dark:bg-[#262626]">
                <h4>Bandeiras</h4>
                <p>{{$bandeiras}}</p>
            </div>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border flex border-neutral-200 bg-[hsl(114,100%,50%)] dark:border-neutral-700 items-center justify-center">
            <div class="w-full h-[98%] rounded-xl flex flex-col items-center justify-center bg-white dark:bg-[#262626]">
                <h4>Unidades</h4>
                <p>{{$unidades}}</p>
            </div>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border flex border-neutral-200 bg-[hsl(114,100%,50%)] dark:border-neutral-700 items-center justify-center">
            <div class="w-full h-[98%] rounded-xl flex flex-col items-center justify-center bg-white dark:bg-[#262626]">
                <h4>Colaboradores</h4>
                <p>{{$colaboradores}}</p>
            </div>
        </div>
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    </div>
</div>
