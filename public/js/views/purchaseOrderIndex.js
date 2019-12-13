$(`${tableId} tbody`).on('click', 'tr .btnDelete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var po_number = $(this).data('number');
    Swal.fire({
        title: 'Apa anda yakin ingin menghapus PO ' + po_number + '?',
        text: "Data yang dihapus tidak dapat dikembaliakn",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `/ajax/purchase-order/${id}`,
                method: 'DELETE',
                data: {
                    "_token": csrf_token
                },
                success: function(res) {
                    dt.row($(this).closest('tr')).remove().draw(false);
                    Swal.fire(
                        'Terhapus!',
                        'Data PO berhasil dihapus.',
                        'success'
                    )
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }
    })
})

