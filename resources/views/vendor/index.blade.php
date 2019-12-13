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
                                    <th>ID</th>
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
            data: 'id',
            name: 'id'
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
    url = 'vendor/json';
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
</script>
@endsection