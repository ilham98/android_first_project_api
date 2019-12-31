
<script>
    var mode = 'tambah';
    var indexID = null;
    var editID = null;
    var idx = 0;

    var items = {!! $items !!};

    for(var x = 0; x < items.length; x++) {
        $('#item-list').append(`
                <li data-index="${ x }" >
                    <span class="nama-val" data-index="${ x }">${ items[x].nama }</span>
                    | Stok: 
                    <span class="stok-val" data-index="${ x }">${ parseInt(items[x].stok) }</span>
                    <i class="btnEdit pe-7s-pen text-success" data-id="${ items[x].id }" data-index="${ x }"></i>
                    <i class="btnDelete pe-7s-trash  text-danger" data-id="${ items[x].id }"></i>
                </li>
            `);
        idx++;
    }

    $('#btnAction').click(function() {
        var nama = $('#item-nama').val();
        var stok = $('#item-stok').val();
        var error = false;
        var onlyNumber = /^\d+$/;
        
        if($('#item-list').children().length > 0) {
            $('#item-list > li').each(function() {
                var index = $(this).data('index');
                var prevNama = $(`.nama-val[data-index="${index}"]`).html();
                if(nama.trim() == prevNama && (indexID != index && mode == 'tambah')) {
                    $('.item-nama-error').html('Nama item yang sama telah diinput sebelumnya');
                    error = true;
                }
            });
        };

        if(nama.trim() == '') {
            $('.item-nama-error').html('Nama wajib diisi');
            error = true;
        }     

        if(stok.trim() == ''){
            $('.item-stok-error').html('Stok wajib diisi');
            error = true;
        }      

        if(onlyNumber.test(stok) == false) {
            $('.item-stok-error').html('Stok harus diisi hanya dengan karakter angka');
            error = true;
        }        

        if(!error) {
            if(mode == 'edit') {
                $.ajax({
                    url: '/ajax/item/'+editID,
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama,
                        stok
                    },
                    success: function() {
                        $(`.nama-val[data-index="${indexID}"]`).html(nama);
                        $(`.stok-val[data-index="${indexID}"]`).html(stok);
                        mode = 'tambah';
                        Swal.fire(
                            'Update Data Berhasil!',
                            'Data PO berhasil diupdate.',
                            'success'
                        )
                    }
                });
                
            } else {
                $.ajax({
                    url: '/ajax/item',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama,
                        stok,
                        purchase_order_id: {!! $purchase_order->id !!}
                    },
                    success: function(res) {
                        $('#item-list').append(`
                            <li data-index="${ idx }">
                                <span class="nama-val" data-index="${ idx }">${ nama }</span>
                                | Stok: 
                                <span class="stok-val" data-index="${ idx }">${ parseInt(stok) }</span>
                                <i class="btnEdit pe-7s-pen text-success" data-index="${ idx }" data-id="${ res.id }"></i>
                                <i class="btnDelete pe-7s-trash  text-danger" data-id="${ res.id }"></i>
                            </li>
                        `);
                        mode = 'tambah';
                        Swal.fire(
                            'Tambah Data Berhasil!',
                            'Data PO berhasil diupdate.',
                            'success'
                        )
                        idx++;
                    }
                });
            }
            $('#itemModal').modal('hide');
        }
    });

    $('#item-list').on('click', '.btnEdit', function() {
        var index = $(this).data('index');
        var nama = $(`.nama-val[data-index="${index}"]`).html();
        var stok = $(`.stok-val[data-index="${index}"]`).html();
        indexID = index;
        editID = $(this).data('id');
        console.log(editID);
        $('#btnAction').html('Update Item');
        mode = 'edit';
        $('#item-nama').val(nama);
        $('#item-stok').val(stok);
        $('.item-nama-error').html('');
        $('.item-stok-error').html('');
        $('#itemModal').modal('show');
    });

    $('#item-list').on('click', '.btnDelete', function() {
        var t = $(this)
        $.ajax({
            url: '/ajax/item/'+$(this).data('id'),
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                t.parent().remove();
                $(this).parent().remove();
                Swal.fire(
                    'Hapus Data Berhasil!',
                    'Data Item Berhasil dihapus.',
                    'success'
                )
            },
            error: function(err) {
                Swal.fire(
                    'Hapus Data Gagal!',
                    'Jumlah item minimal untuk setiap purchase order adalah 1.',
                    'error'
                )
            }
        });
    });

    $('#openItemModal').click(function() {
        $('#btnAction').html('Tambah Item');
        $('#item-nama').val('');
        $('#item-stok').val('');
        $('.item-nama-error').html('');
        $('.item-stok-error').html('');
        $('#itemModal').modal('show');
    });

    $("#purchaseOrderForm").validate({
        ignore: ':hidden:not([class~=selectized]),:hidden > .selectized, .selectize-control .selectize-input input',
        rules: {
            date: "required",
            vendor_id: "required",
            po_number: "required"
        },
        errorPlacement: function(label, element) {
            label.addClass('jquery-validate-error-message');
            label.insertAfter(element);
        },
        wrapper: 'div',
        submitHandler: function() {
            if($('#item-list').children().length > 0) {
                itemArr = [];
                $('#item-list > li').each(function() {
                    var index = $(this).data('index');
                    var nama = $(`.nama-val[data-index="${index}"]`).html();
                    var stok = $(`.stok-val[data-index="${index}"]`).html();
                    itemArr.push({
                        nama, stok
                    });
                });
                $.ajax({
                    url: '/ajax/purchase-order/'+{{ $purchase_order->id }},
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: JSON.stringify(itemArr),
                        date: $('#date').val(),
                        vendor_id: $('#vendor_id').val(),
                        po_number: $('#po_number').val()
                    },
                    success: function() {
                        Swal.fire(
                            'Update Data Berhasil!',
                            'Data PO berhasil diupdate.',
                            'success'
                        )
                    }
                });
            } else {
                Swal.fire(
                    'Error!',
                    'Tambahkan minimal 1 Item untuk menyimpan data purchase order.',
                    'error'
                )
            }
            
            
            // $.ajax({
            //     url: '/ajax/purchase-order',
            //     method: 'POST',

            // });
        }
    });

    var itemArr = [];
</script>