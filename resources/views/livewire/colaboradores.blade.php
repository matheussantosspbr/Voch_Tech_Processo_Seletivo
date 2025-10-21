<x-slot:title>Colaboradores</x-slot:title>
<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    @include('partials.sessions-messages')
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <h1>Colaboradores</h1>
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

        <div class="p-4 flex flex-col justify-start items-center  w-full">
            <form wire:submit="save" class="flex itens-center justify-center flex-row w-full mb-8">
                <div class="mr-8 w-[20%]">
                    <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
                    <input wire:model="nome" type="text" id="nome" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example" required />
                </div>
                <div class="mr-8 w-[20%]">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input wire:model="email" type="text" id="email" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 dark:bg-[#262626] dark:border-neutral-700  dark:text-white" placeholder="example@example.com" required />
                </div>
                <div class="mr-8 w-[20%]">
                    <label for="cpf" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CPF</label>
                    <input 
                        wire:model="cpf"
                        type="text"
                        id="cpf"
                        class="cpf-mask w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 
                            dark:bg-[#262626] dark:border-neutral-700 dark:text-white"
                        placeholder="000.000.000-00"
                        required
                    />
                </div>
                <div class="mr-8 w-[20%]">
                    <label for="id_unidade" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome da Bandeira</label>
                    <select wire:model="id_unidade" id="id_unidade" class="w-full text-sm p-1 border-neutral-700 dark:bg-[#262626] h-10 rounded-xl border" required>
                        <option value="" selected>Selecione</option>
                        @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id_unidade }}">{{ $unidade->nome_fantasia }}</option>
                        @endforeach
                    </select>
                </div>
            
                <button type="submit" class="mt-7 bg-blue-500 p-2 h-10 w-[5%] rounded-xl cursor-pointer">
                    <flux:icon name="plus" class="h-5 w-5 text-white mx-auto"></flux:icon> 
                </button>                 
            </form>
            
            <div class="w-full p-4 px-4">
                <table id="search-table" class="w-full border bg-neutral-600 border-neutral-600 dark:border-neutral-500 dark:bg-neutral-500 rounded-sm border-separate overflow-hidden">
                    <thead class="border-b border-neutral-300 dark:bg-neutral-600">
                        <tr>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Nome
                            </th>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Email
                            </th>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                CPF
                            </th>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Unidade
                            </th>
                            <th class="p-2 text-center text-neutral-50 rounded-sm">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colaboradores as $colaborador)
                            <tr class="bg-neutral-50 dark:bg-[#262626] dark:hover:bg-neutral-700 border border-neutral-50">
                                <td class="p-2 text-center rounded-sm">
                                    {{ $colaborador->nome }}
                                </td>
                                <td class="p-2 text-center rounded-sm">
                                    {{ $colaborador->email }}
                                </td>
                                <td class="p-2 text-center rounded-sm">
                                    {{ App\Http\Helper\DocumentosHelper::formatCPF($colaborador->cpf) }}
                                </td>
                                <td class="p-2 text-center rounded-sm">
                                    {{ $colaborador->unidades->nome_fantasia }}
                                </td>
                                <td class="rounded-sm p-2 text-center gap-2">
                                    <button 
                                        data-id="{{ $colaborador->id_colaborador }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white p-1 rounded cursor-pointer edit mr-1">
                                        <flux:icon name="pencil-square" class="h-5 w-5 text-white mx-auto" />
                                    </button>
                                    <button
                                        class="bg-red-500 hover:bg-red-600 text-white p-1 rounded cursor-pointer delete ml-1"
                                        data-id="{{ $colaborador->id_colaborador }}">
                                        <flux:icon name="trash" class="h-5 w-5 text-white mx-auto" />
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 text-center text-white">
                                    Nenhum colaborador cadastrado.
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
    $(document).ready(function() {
        $('.cpf-mask').mask('000.000.000-00');
    });

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
        const id_colaborador = $(this).data('id');
        modelDeleteAjax("{{route('colaboradores.delete')}}", { id_colaborador: id_colaborador }, '{{ csrf_token() }}');
    });

    $('.edit').click(function (e) { 
        e.preventDefault();

        const row = $(this).closest('tr');
        const nome = row.find('td:eq(0)').text().trim();
        const email = row.find('td:eq(1)').text().trim();
        const cpf = row.find('td:eq(2)').text().trim();
        const unidade = row.find('td:eq(3)').text().trim();
        const id_colaborador = $(this).data('id');
        
        Swal.fire({
            title: "Editar Unidade",
            theme: 'auto',
            html: `
                <div class="mt-4 flex flex-col text-start">
                    <label for="swal-input1" class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                        Nome:
                    </label>
                    <input id="swal-input1" class="swal2-input w-full" style="margin:0" value="${nome}">
                </div>
                <div class="mt-4 flex flex-col text-start">
                    <label for="swal-input2" class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                        Email:
                    </label>
                    <input id="swal-input2" class="swal2-input w-full" style="margin:0" value="${email}">
                </div>
                <div class="mt-4 flex flex-col text-start">
                    <label for="swal-input3" class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                        CPF:
                    </label>
                    <input id="swal-input3" class="cnpj-mask swal2-input w-full" style="margin:0" value="${cpf}" maxlength="18">
                </div>
                <div class="mt-4 flex flex-col text-start">
                    <label for="swal-input4" class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                        Unidades:
                    </label>
                    <select id="swal-input4" class="swal2-input w-full">
                        @foreach($unidades as $unidade)
                            <option value="{{ $unidade->id_unidade }}" 
                                ${'{{ $unidade->nome_fantasia }}' === unidade ? 'selected' : ''}>
                                {{ $unidade->nome_fantasia }}
                            </option>
                        @endforeach
                    </select>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: "Salvar",
            cancelButtonText: "Cancelar",
            focusConfirm: false,
            preConfirm: () => {
                return {
                    nome: document.getElementById("swal-input1").value,
                    email: document.getElementById("swal-input2").value,
                    cpf: document.getElementById("swal-input3").value,
                    id_unidade: document.getElementById("swal-input4").value
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { nome, email, cpf, id_unidade } = result.value;
    
                $.ajax({
                    type: "POST",
                    url: "/colaboradores/update",
                    data: JSON.stringify({
                        id_colaborador: id_colaborador,
                        nome: nome,
                        email: email,
                        cpf: cpf,
                        id_unidade: id_unidade
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