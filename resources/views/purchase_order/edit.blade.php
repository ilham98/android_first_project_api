@extends('master')

@section('content')

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="mb-3 card">
                    <div class="card-header-tab card-header-tab-animation card-header">
                        <div class="card-header-title">
                            <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                            Purchase Order
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="purchaseOrderForm" action="{{ url('purchase-order') }}" class='col-sm-6' method='POST'>
                            <h6 class='font-weight-bold'>Purchase Order Details</h6>
                            <hr>
                            <div class='form-group'>
                                <label>Date</label>
                                <input type="date" name='date' id="date" value='{{ $purchase_order->date }}' class='form-control'>
                            </div>
                            @if($errors->has('date'))
                            <p class='text-danger'>{{ $errors->first('date') }}</p>
                            @endif
                            <div class='form-group'>
                                <label>Vendor</label>
                                <select name='vendor_id' id="vendor_id" class='form-control'>
                                    <option value="">Pilih Nama Vendor</option>
                                    @foreach($vendor as $v)
                                        <option {{ $purchase_order->vendor_id == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('vendor_id'))
                            <p class='text-danger'>{{ $errors->first('vendor_id') }}</p>
                            @endif
                            <div class='form-group'>
                                <label>PO Number</label>
                                <input type="" name='po_number' id="po_number" value='{{ $purchase_order->po_number }}' class='form-control'>
                            </div>
                            @if($errors->has('po_number'))
                                <p class='text-danger'>{{ $errors->first('po_number') }}</p>
                            @endif
                            <div class='form-group mt-5'>
                                <input type='submit' class='btn btn-primary' value='Update Purchase Order'>
                            </div>

                            <h6 class='font-weight-bold mt-5'>Item Details</h6>
                            <hr>
                            <ol class="ml-3" id="item-list">
                                
                            </ol>
                            <!-- width: 0px; height: 0px; border: none -->
                            <input type="text" style="width: 0px; height: 0px; border: none" value="" id="item" name="item">
                            <button type="button" class="btn btn-primary" id="openItemModal">Tambah Item</button>

                            @csrf
                            @method('PUT')
                            
                        </form>

                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra')
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Item Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="itemForm">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="item-nama" class="form-control" value="">
                        <p class="text-danger item-nama-error"></p>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="text" id="item-stok" class="form-control">
                        <p class="text-danger item-stok-error"></p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btnTutupItem" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnAction">Tambah</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('js/jqueryValidation.min.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
@endsection