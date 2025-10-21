<x-slot:title>Relatórios</x-slot:title>
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <h1>Relatórios</h1>
    </div>
    <div class="relative h-full flex-1 overflow-hidden p-4 rounded-xl border border-neutral-200 dark:border-neutral-700">

        <div class="flex flex-row items-center">
            <div class="flex flex-col w-64 p-4 ">
                <label for="">Tipo de Relatório</label>
                <select wire:model="report_title" name="" id="" class="mt-2 w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border">
                    <option value="" selected>Selecione</option>
                    <option value="grupos_economicos">Grupos Econômicos</option>
                    <option value="bandeiras">Bandeiras</option>
                    <option value="unidades">Unidades</option>
                    <option value="colaboradores">Colaboradores</option>
                </select>
            </div>
            <button wire:click="getReport" class="cursor-pointer h-10 mt-8 border border-neutral-700 p-2 bg-blue-500 hover:bg-blue-400 rounded-xl">
                <flux:icon name="magnifying-glass" class="h-5 w-5 text-white mx-auto"></flux:icon>
            </button>
        </div>
        <div class="p-4 flex flex-row items-end justify-between">
            @if($report_title)
                @switch($report_title)
                    @case('grupos_economicos')
                        @include('livewire.report-filters.grupos-economicos-filtro')
                        <button wire:click="export" class="cursor-pointer h-10 mb-4 border border-neutral-700 p-2 bg-green-500 hover:bg-green-400 rounded-xl">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            Extrair
                        </button>
                        @break
                    @case('bandeiras')
                        @include('livewire.report-filters.bandeiras-filtro')
                        <button wire:click="export" class="cursor-pointer h-10 mb-4 border border-neutral-700 p-2 bg-green-500 hover:bg-green-400 rounded-xl">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            Extrair
                        </button>
                        @break
                    @case('unidades')
                        @include('livewire.report-filters.unidades-filtro')
                        <button wire:click="export" class="cursor-pointer h-10 mb-4 border border-neutral-700 p-2 bg-green-500 hover:bg-green-400 rounded-xl">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            Extrair
                        </button>
                        @break
                    @case('colaboradores')
                        @include('livewire.report-filters.colaboradores-filtro')
                        <button wire:click="export" class="cursor-pointer h-10 mb-4 border border-neutral-700 p-2 bg-green-500 hover:bg-green-400 rounded-xl">
                            <i class="fa-solid fa-file-arrow-down"></i>
                            Extrair
                        </button>
                        @break
                    @default
                @endswitch
            @endif
            
        </div>
        
        <div class="p-4">
            @if ($report)
                <table class="w-full border bg-neutral-600 border-neutral-600 dark:border-neutral-500 dark:bg-neutral-500 rounded-sm border-separate overflow-hidden">
                    <thead class="border-b border-neutral-300 dark:bg-neutral-600">
                        @foreach($colunas as $coluna)
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                {{ $coluna }}
                            </th>
                        @endforeach
                    </thead>
                    <tbody>
                        @foreach($report as $linha)
                            <tr class="bg-neutral-50 dark:bg-[#262626] dark:hover:bg-neutral-700 border border-neutral-50">
                                @foreach($col_dinamic as $col)
                                    <td class="p-2 text-center rounded-sm">
                                        {{ $linha[$col] }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="ml-4 w-[98%] bg-neutral-600 h-6 text-center">Escolha qual relatório deseja ver.</div>
            @endif
        </div>
        
    </div>
</div>