$('.btn-danger').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    let title, text, confirm;
    if($(this).attr('id') == 'del-purchase' || $(this).attr('id') == 'del-sale'){
        title = '¿Estás seguro que deseas cancelarla?';
        text = 'Se borrarán todos sus detalles';
        confirm = 'Si, Cancelala';
        cancel = 'No';
    }
    else{
        title = '¿Estás seguro que deseas eliminar el registro?';
        text = "No podrás recuperar los datos después de eliminarlos.";
        confirm = 'Si, Eliminalo';
        cancel = 'Cancelar';
    }
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: confirm,
        cancelButtonText: cancel
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});