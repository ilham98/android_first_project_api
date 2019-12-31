@extends('master')

@section('title', config('app.name').' | Aset')

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
                    <div>

                    </div>
                    <div class="card-body pt-0">
                        <div class='d-flex justify-content-end my-4'>
                            <a href="{{ url('aset/tambah') }}" class='btn btn-primary'>Tambah Aset</a>
                        </div>
                        <div class="table-responsive">
                            <table class='table' style="width: 100%" id='aset-table'>
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Registration Number</th>
                                        <th>Po Number</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Department</th>
                                        <th>Vendor Name</th>
                                        <th>Status Tracking</th>
                                        <th>Tanggal Dibuat</th>                                        
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src='{{ asset('js/dataTables.js') }}'></script>
<script src='{{ asset('js/dataTablesBootstrap4.js') }}'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="cdn.datatables.net/plug-ins/1.10.20/filtering/row-based/range_dates.js"></script>
<script>
    var csrf_token = "{{ csrf_token() }}";
    var dt = $('#aset-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
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
                data: 'po_number',
                name: 'po_number'
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
                data: 'status_tracking',
                name: 'status_tracking'
            },
            {
                data: 'created_on',
                name: 'created_on'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#min').change( function() { table.draw(); } );
    $('#max').change( function() { table.draw(); } );

    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();

    @if(session('store-success'))
        Swal.fire(
            'Insert Sukses!',
            "{!! session('store-success') !!}",
            'success'
        );
    @endif

    @if(session('update-success'))
        Swal.fire(
            'Update Sukses!',
            "{!! session('update-success') !!}",
            'success'
        );
    @endif

    $(`table tbody`).on('click', 'tr .btnDelete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Aset?',
            text: `Apa anda yakin ingin menghapus data aset?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/ajax/aset/${id}`,
                    method: 'DELETE',
                    data: {
                        "_token": csrf_token
                    },
                    success: function(res) {
                        dt.row($(this).closest('tr')).remove().draw(false);
                        Swal.fire(
                            'Terhapus!',
                            'Data Aset dihapus.',
                            'success'
                        )
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal menghapus!',
                            'Penghapusan Data Aset gagal.',
                            'error'
                        )
                    }
                })
            }
        })
    })

    $('#filterButton').click(function() {
        dt.ajax.reload();
    });

    
</script>
@endsection