function show_confirm_sweet(title, msj_confirm){
    return Swal.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: msj_confirm,
        cancelButtonText: 'Cancelar'
    });
}

function show_charge_message(){
    Swal.fire({
        title: 'Cargando...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function show_yes_no_sweet(title){
    return Swal.fire({
        title: title,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Si!',
        cancelButtonText: '¡No!'
    });
}