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
                            Aset
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class='d-flex justify-content-end my-4'>
                            <a href="{{ url('aset/tambah') }}" class='btn btn-primary'>Tambah Aset</a>
                        </div>
                        <table class='table' style="width: 100%" id='aset-table'>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Registration Number</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>User</th>
                                    <th>Department</th>
                                    <th>Vendor Name</th>
                                    <th></th>
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
    var dt = $('#aset-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': '/aset/json',
            'headers': {
                'access_token': 'hello'
            }
        },
        columns: [{
                data: null,
                searchable: false,
                orderable: false
            },
            {
                data: 'registration_number',
                name: 'registration_number'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'user',
                name: 'user'
            },
            {
                data: 'departemen',
                name: 'departemen'
            },
            {
                data: 'vendor_name',
                name: 'vendor_name'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
    
</script>
@endsection