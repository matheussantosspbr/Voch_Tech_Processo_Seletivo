
<div class="w-[90%]">
    <h2>Filtros</h2>
    <span class="text-sm">Se não quiser filtros apenas deixe em branco</span>
    <div class="flex flex-row items-center">
        <div class="flex flex-col w-64">
            <label for="">Nome</label>
            <input wire:model="filter.field_name" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required>
        </div>
        <div class="flex flex-col w-64 ml-4">
            <label for="">Id do Grupo Econômico</label>
            <input wire:model="filter.field_id_rel" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required>
        </div>       
        <div class="flex flex-col w-64 p-4">
            <label for="">Campo de ordenação</label>
            <select wire:model="filter.field_title" class="mt-2 w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border">
                <option value="" selected>Selecione</option>
                <option value="nome">Nome</option>
                <option value="created_at">Data de criação</option>
                <option value="updated_at">Ultima atualização</option>
            </select>
        </div>
        <div class="flex flex-col w-64 p-4">
            <label for="">Ordem</label>
            <select wire:model="filter.field_order_title" class="mt-2 w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border">
                <option value="" selected>Selecione</option>
                <option value="asc">Crescente</option>
                <option value="desc">Decrescente</option>
            </select>
        </div>
        <button wire:click="filterReport" class="cursor-pointer h-10 mt-8 border border-neutral-700 p-2 bg-blue-500 hover:bg-blue-400 rounded-xl">
            <flux:icon name="funnel" class="h-5 w-5 text-white mx-auto"></flux:icon>
        </button>
    </div>
</div>