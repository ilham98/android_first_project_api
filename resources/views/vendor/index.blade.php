@extends('master')

@section('title', config('app.name').' | Vendor')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTablesBootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTablesBoostrap4AdditionalConfiguration.css') }}">
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
                            Vendor
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="my-3 d-flex justify-content-between">
                            <input id='csvFile' type='file' hidden />
                            <button class="btn btn-primary" id="btnImport">Import File Excel</button>
                            <a class="btn btn-primary" id="btnImport" href="{{ url('vendor/tambah') }}">Tambah Vendor</a>
                        </div>
                        <table class='table' id='vendor-table' style="width: 100%">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Nama Vendor</th>
                                    <th>Contact Person</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src='{{ asset('js/dataTables.js') }}'></script>
<script src='{{ asset('js/dataTablesBootstrap4.js') }}'></script>
<script>
    var tableId = "#vendor-table";
    var columns = [{
            data: null,
            searchable: false,
            orderable: false
        },
        {
            data: 'nama',
            name: 'nama'
        },
        {
            data: 'contact_person',
            name: 'contact_person'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ];
    var url = 'vendor/json';
    var csrf_token = "{{ csrf_token() }}"
</script>
<script src="{{ asset('js/dataTablesAdditionalConfiguration.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $('#btnImport').click(function() {
        $('#csvFile').click();
        
    });

    $('#csvFile').change(function(e) {
        var formData = new FormData();
        formData.append('csvFile', $(this)[0].files[0]);
        formData.append('_token', "{{ csrf_token() }}");

        $.ajax({
                url: '/vendor/import',
                type: 'POST',
                data: formData,
                async: false,
                success: function (data) {
                    var myWindow = window.open("/vendor/import", "", "width=800,height=400"); 
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
        });

        $(`${tableId} tbody`).on('click', 'tr .btnDelete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');    
        var nama = $(this).data('nama');
        Swal.fire({
            title: 'Apa anda yakin ingin menghapus vendor ' + nama + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/ajax/vendor/${id}`,
                    method: 'DELETE',
                    data: {
                        "_token": csrf_token
                    },
                    success: function(res) {
                        dt.row($(this).closest('tr')).remove().draw(false);
                        Swal.fire(
                            'Terhapus!',
                            'Data Vendor berhasil dihapus.',
                            'success'
                        );
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal Hapus!',
                            'Data Vendor '+ nama +' gagal dihapus, disebabkan oleh Purchase Order yang memiliki relasi dengan vendor ini.',
                            'error'
                        );
                    }
                })
            }
        })
    })

    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();


</script>
@endsection