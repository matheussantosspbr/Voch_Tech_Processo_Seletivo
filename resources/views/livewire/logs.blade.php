<x-slot:title>Atividades</x-slot:title>
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <h1>Atividades</h1>
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <div class="w-full p-4 px-4">
            <table id="search-table" class="w-full border bg-neutral-600 dark:border-neutral-500 dark:bg-neutral-500 rounded-sm border-separate overflow-hidden">
                <thead class="border-b border-neutral-300 dark:bg-neutral-600">
                    <tr>
                        <th class="p-2 text-center text-neutral-50 rounded-sm">
                            Usuário
                        </th>
                        <th class="p-2 text-center text-neutral-50 rounded-sm">
                            Descricao
                        </th>
                        <th class="p-2 text-center text-neutral-50 rounded-sm">
                            Rota
                        </th>
                        <th class="p-2 text-center text-neutral-50 rounded-sm">
                            Data de Criaçao
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="bg-neutral-50 dark:bg-[#262626] dark:hover:bg-neutral-700 border border-neutral-50">
                            <td class="p-2 text-center rounded-sm">
                                {{ $log->usuario }}
                            </td>
                            <td class="p-2 text-center rounded-sm">
                                {{ $log->descricao }}
                            </td>
                            <td class="p-2 text-center rounded-sm">
                                {{ $log->rota }}
                            </td>
                            <td class="p-2 text-center rounded-sm">
                                {{ $log->created_at }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-2 text-center text-neutral-50 rounded-sm">
                                Nenhum dado no sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#search-table", {
            searchable: true,
            sortable: true,
            template: (options, dom) => `
            <div class='flex items-center justify-between flex-row-reverse mb-4'>
                ${
                    options.paging && options.perPageSelect ?
                        `<div class='${options.classes.dropdown}'>
                            <label>
                                <select class='${options.classes.selector} p-2 border-1 h-10 rounded-sm dark:border-neutral-700 dark:bg-[#262626] dark:text-white'></select> Nº Itens
                            </label>
                        </div>` :
                        ""
                }
                ${
                    options.searchable ?
                        `<div class='${options.classes.search}'>
                            <input class='${options.classes.input} bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-[#262626] dark:border-neutral-700 dark:placeholder-neutral-500 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' placeholder='${options.labels.placeholder}' type='search' title='${options.labels.searchTitle}'${dom.id ? ` aria-controls="${dom.id}"` : ""}>
                        </div>` :
                        ""
                }
            </div>
            <div class='${options.classes.container}'${options.scrollY.length ? ` style='height: ${options.scrollY}; overflow-Y: auto;'` : ""}></div>
            <div class='${options.classes.bottom}'>
                ${
                    options.paging ?
                        `<div class='${options.classes.info} mt-4'></div>` :
                        ""
                }
                <nav class='${options.classes.pagination}' id="pagination"></nav>
            </div>`
        });
    }
</script>
