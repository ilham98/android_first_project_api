@extends('master')

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
                            Permintaan Pengeluaran Barang
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="my-3 d-flex justify-content-between">
                            <input id='csvFile' type='file' hidden />
                            <button class="btn btn-primary" id="btnImport">Import File Excel</button>
                            <a class="btn btn-primary" href="{{ url()->current().'/tambah' }}">Tambah Permintaan Pengeluaran Barang</a>
                        </div>
                        <table class='table' id='pengeluaran-barang-table' style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Department</th>
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
    var tableId = "#pengeluaran-barang-table";
    var columns = [
        {
            data: null,
            searchable: false,
            orderable: false
        },
        {
            data: 'no_surat',
            name: 'no_surat'
        },
        {
            data: 'departemen',
            name: 'departemen'
        }
    ];
    url = 'permintaan-pengeluaran-barang/json';
</script>
<script src="{{ asset('js/dataTablesAdditionalConfiguration.js') }}"></script>
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

    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
</script>
@endsection