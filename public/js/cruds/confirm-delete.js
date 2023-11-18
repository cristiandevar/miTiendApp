$('.btn-danger').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: '¿Estás seguro que deseas eliminarlo?',
        text: "No podrás recuperar los datos después de eliminarlos.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});