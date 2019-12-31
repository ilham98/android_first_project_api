@extends('master')

@section('title', config('app.name').' | Tambah PO')

@section('style')
    <style>
        table {
        counter-reset: rowNumber;
        }

        table tbody tr {
            counter-increment: rowNumber;
        }

        table tbody tr td:first-child::before {
            content: counter(rowNumber);
            min-width: 1em;
            margin-right: 0.5em;
        }
    </style>
@endsection

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
                                <input type="date" name='date' id="date" value='{{ old("date") }}' class='form-control'>
                            </div>
                            @if($errors->has('date'))
                            <p class='text-danger'>{{ $errors->first('date') }}</p>
                            @endif
                            <div class='form-group'>
                                <label>Vendor</label>
                                <select name='vendor_id' id="vendor_id"  value='{{ old("vendor_id") }}' class='form-control'>
                                    <option value="">Pilih Nama Vendor</option>
                                    @foreach($vendor as $v)
                                    <option value="{{ $v->id }}">{{ $v->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('vendor_id'))
                            <p class='text-danger'>{{ $errors->first('vendor_id') }}</p>
                            @endif
                            <div class='form-group'>
                                <label>PO Number</label>
                                <input type="" name='po_number' id="po_number" value='{{ old("po_number") }}' class='form-control'>
                            </div>
                            @if($errors->has('po_number'))
                            <p class='text-danger'>{{ $errors->first('po_number') }}</p>
                            @endif

                            <h6 class='font-weight-bold mt-5'>Item Details</h6>
                            <table class="table" id="itemTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Stok</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            <!-- width: 0px; height: 0px; border: none -->
                            <input type="text" style="width: 0px; height: 0px; border: none" value="" id="item" name="item">
                            <button type="button" class="btn btn-primary" id="openItemModal">Tambah Item</button>

                            @csrf
                            @method('POST')
                            <div class='form-group mt-5'>
                                <input type='submit' class='btn btn-primary' value='Tambah Purchase Order'>
                            </div>
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
                        <input type="text" id="item-nama" class="form-control">
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
                <button type="button" class="btn btn-secondary" id="buttonTutupModal" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="buttonTambahItem">Tambah</button>
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
    var buttonOpenItemModal = $('#openItemModal');
    var buttonTutupModal = $('#buttonTutupModal');
    var buttonTambahItem = $('#buttonTambahItem');
    var tableItem = $('#itemTable');
    var tbodyTableItem = $('#itemTable tbody');
    var itemNama = $('#item-nama');
    var itemStok = $('#item-stok');
    var modeEdit = false;
    var editId = null;

    var openModal = function() {
        $('#itemModal').modal('show');
    };
    
    var closeModal = function() {
        $('#itemModal').modal('hide');
    }

    buttonOpenItemModal.click(function() {
        modeEdit = false;
        editId = null;
        $('#buttonTambahItem').html('Tambah');
        $('#item-nama').val('');
        $('#item-stok').val('');
        openModal();
    });

    $('body').on('click', '.itemEdit', function() {
        $('#buttonTambahItem').html('Edit');
        var trIndex = $(this).closest('tr').index();
        var itemNamaTable = $('#itemTable tbody :nth-child('+ (trIndex+1) +') .itemNamaVal');
        var itemStokTable = $('#itemTable tbody :nth-child('+ (trIndex+1) +') .itemStokVal');
        modeEdit = true;
        editId = trIndex;
        itemNama.val(itemNamaTable.html());
        itemStok.val(itemStokTable.html());
        // console.log(trLen);
        openModal();
    });

    $('body').on('click', '.itemDelete', function() {
        var trIndex = $(this).closest('tr').index();
        var tr = $('#itemTable tbody :nth-child('+ trIndex+1 +')tr');
        tr.remove();
    });


    function isValid(nama, stok) {
        error = false;       
        if(tbodyTableItem.children().length > 0) {
            $('#itemTable tbody tr').each(function() {
                var index = $(this).index();
                var namaPrev = $(this).children('.itemNamaVal').html();
                var stokPrev = $(this).children('.itemStokVal').html();
                // console.log(index, editId);
                if(nama.trim() == namaPrev && (editId != index || modeEdit == false)) {
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

        if(/^\d+$/.test(stok) == false) {
            $('.item-stok-error').html('Stok wajib disisi dengan angka');
            error = true;
        }

        return !error;
    }

    function appendNamaToTbody(itemNamaVal, itemStokVal) {
        var tbodyChild = tbodyTableItem.children().length;
        $('.item-nama-error').html('');
        $('.item-stok-error').html('');
        tbodyTableItem.append(`
            <tr class='itemContainer'>
                <td></td>
                <td class='itemNamaVal'>${ itemNamaVal }</td>
                <td class='itemStokVal'>${ itemStokVal }</td>
                <td>
                    <i class='pe-7s-pen text-success itemEdit' />
                    <i class='pe-7s-trash  text-danger itemDelete' />  
                </td>
            </tr>
        `);

        closeModal();
    }

    function editTbody(itemNamaVal, itemStokVal) {
        var tbodyChild = tbodyTableItem.children().length;
        var itemNamaTable = $('#itemTable tbody :nth-child('+ (editId+1) +') .itemNamaVal');
        var itemStokTable = $('#itemTable tbody :nth-child('+ (editId+1) +') .itemStokVal');
        itemNamaTable.html(itemNamaVal);
        itemStokTable.html(itemStokVal);
        
        closeModal();
    }

    buttonTambahItem.click(function() {
        var itemNamaVal = itemNama.val();
        var itemStokVal = itemStok.val();
    
        if(!modeEdit) {
            if(isValid(itemNamaVal, itemStokVal)) {
                console.log('condition 1');
                appendNamaToTbody(itemNamaVal, itemStokVal);
            }
        } else {
            console.log('condition 2');
            editTbody(itemNamaVal, itemStokVal);
        }
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
            if($('#itemTable tbody').children().length > 0) {
                itemArr = [];
                $('#itemTable tbody tr').each(function() {
                    var index = $(this).data('index');
                    var nama = $(this).children('.itemNamaVal').html();
                    var stok = $(this).children('.itemStokVal').html();
                    itemArr.push({
                        nama, stok
                    });
                });
                $.ajax({
                    url: '/ajax/purchase-order',
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        items: JSON.stringify(itemArr),
                        date: $('#date').val(),
                        vendor_id: $('#vendor_id').val(),
                        po_number: $('#po_number').val()
                    },
                    success: function() {
                        $('#po_number').val('');
                        $('#vendor_id').val('');
                        $('#date').val(''),
                        $('#itemTable tbody').html('');
                        Swal.fire(
                            'Tambah Data Berhasil!',
                            'Data PO berhasil ditambahkan.',
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

</script>
@endsection