<x-slot:title>Grupos Econômicos</x-slot:title>
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <h1>Grupos Econômicos</h1>
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        <div class="p-4 flex flex-col justify-start items-center  w-full">
            <form wire:submit="save" class="flex itens-center justify-center flex-row w-full mb-8">
                <div class="mr-8 w-[90%]">
                    <label for="grupo_economico" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome do grupo econômico</label>
                    <input wire:model="grupo_economico" type="text" id="grupo_economico" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required />
                </div>
            
                <button type="submit" class="mt-7 bg-blue-500 p-2 h-10 w-[5%] rounded-xl cursor-pointer">
                    <flux:icon name="plus" class="h-5 w-5 text-white mx-auto"></flux:icon> 
                </button>                 
            </form>
            
            <div class="w-full p-4 px-4">
                <table id="search-table" class="w-full border bg-neutral-600 dark:border-neutral-500 dark:bg-neutral-500 rounded-sm border-separate overflow-hidden">
                    <thead class="border-b border-neutral-300 dark:bg-neutral-600">
                        <tr>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Nome do Grupo Econômico
                            </th>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grupos_economicos as $grupo_economico)
                            <tr class="bg-neutral-50 dark:bg-[#262626] dark:hover:bg-neutral-700 border border-neutral-50">
                                <td class="p-2 text-center rounded-sm">
                                    {{ $grupo_economico->nome }}
                                </td>
                                <td class="rounded-sm p-2 text-center gap-2">
                                    <button 
                                        data-id="{{ $grupo_economico->id_grupo_economico }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-1 rounded cursor-pointer edit mr-1">
                                        <flux:icon name="pencil-square" class="h-5 w-5 text-white mx-auto" />
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white p-1 rounded cursor-pointer delete ml-1"
                                        data-id="{{ $grupo_economico->id_grupo_economico }}">
                                        <flux:icon name="trash" class="h-5 w-5 text-white mx-auto" />
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="p-2 text-center text-neutral-50 rounded-sm">
                                    Nenhum grupo econômico cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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

    $('.delete').click(function (e) { 
        e.preventDefault();
        const id_grupo_economico = $(this).data('id');
        modelDeleteAjax("{{route('grupos_economicos.delete')}}", { id_grupo_economico: id_grupo_economico }, '{{ csrf_token() }}');
    });

    $('.edit').click(function (e) { 
        e.preventDefault();

        const row = $(this).closest('tr');
        const nomeAtual = row.find('td:first').text().trim();
        const id_grupo_economico = $(this).data('id');
        Swal.fire({
            title: "Editar grupo econômico",
            input: "text",
            inputLabel: "Novo nome do grupo",
            inputValue: nomeAtual,
            showCancelButton: true,
            confirmButtonText: "Salvar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            theme: 'auto',
            inputValidator: (value) => {
                if (!value) {
                    return "O nome não pode estar vazio!";
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const novoNome = result.value;
                $.ajax({
                    type: "POST",
                    url: "/grupos_economicos/update",
                    data: JSON.stringify({
                        id_grupo_economico: id_grupo_economico,
                        nome: novoNome
                    }),
                    dataType: "json",
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        fireAlert("Atualizado com sucesso!", response.message, true );
                    },
                    error: function (error) {
                        fireAlert("Erro !", error.responseJSON.message, true, "error");
                    }
                });
            }
        });
    });
</script>
