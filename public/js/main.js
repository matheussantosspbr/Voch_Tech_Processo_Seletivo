function fireAlert(title, message, refresh = false, icon = 'success'){
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        theme: 'auto'
    }).then(() => refresh ? location.reload() : null);
}

function modelDeleteAjax(route, data, csrf){
    Swal.fire({
        title: "Tem certeza que deseja excluir?",
        text: "Você não poderá reverter isso!",
        icon: "warning",
        theme:'auto',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sim, exclua!"
    }).then((result) => {
        if (result.isConfirmed) {
                $.ajax({
                type: "POST",
                url: route,
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json",
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                success: function (response) {
                    fireAlert("Deletado com sucesso!", response.message, true );
                },
                error: function (error) {
                    fireAlert("Erro !", error.responseJSON.message, true, "error")
                }
            });
        }
    });
}