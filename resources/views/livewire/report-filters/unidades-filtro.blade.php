
<div class="w-[90%]">
    <h2>Filtros</h2>
    <span class="text-sm">Se não quiser filtros apenas deixe em branco</span>
    <div class="flex flex-col items-start mt-4">
        <div class="flex flex-row mb-4">
            <div class="flex flex-col w-64">
                <label for="">Nome fantasia</label>
                <input wire:model="filter.field_name_fantasy" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required>
            </div>
            <div class="flex flex-col w-64 ml-4">
                <label for="">Razão social</label>
                <input wire:model="filter.field_corporate_reason" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required>
            </div>
            <div class="flex flex-col w-64 ml-4">
                <label for="">CNPJ</label>
                <input wire:model="filter.field_cnpj" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="00000000000000" required>
            </div>
        </div>
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-col w-64">
                <label for="">ID da bandeira</label>
                <input wire:model="filter.field_id_rel" type="text" class="mt-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required>
            </div>
            <div class="flex flex-col w-64 p-4">
                <label for="">Campo de ordenação</label>
                <select wire:model="filter.field_order_title" class="mt-2 w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border">
                    <option value="" selected>Selecione</option>
                    <option value="nome_fantasia">Nome fantasia</option>
                    <option value="razao_social">Razão social</option>
                    <option value="created_at">Data de criação</option>
                    <option value="updated_at">Ultima atualização</option>
                </select>
            </div>
            <div class="flex flex-col w-64 p-4">
                <label for="">Ordem</label>
                <select wire:model="filter.field_order" class="mt-2 w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border">
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
</div>