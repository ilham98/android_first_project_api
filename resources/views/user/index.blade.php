@extends('master')

@section('title', config('app.name').' | User')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTablesBootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTablesBoostrap4AdditionalConfiguration.css') }}">
@endsection

@section('content')

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="col-md-12 col-lg-12">
            <div class="mb-3 card">
                <div class="card-header-tab card-header-tab-animation card-header">
                    <div class="card-header-title">
                        <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
                        User
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class='d-flex justify-content-end my-4'>
                        <a href="{{ url('user/tambah') }}" class='btn btn-primary'>Tambah User</a>
                    </div>
                    <table class='table' id='user-table' style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NPK</th>
                                <th>Role</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src='{{ asset('js/dataTables.js') }}'></script>
<script src='{{ asset('js/dataTablesBootstrap4.js') }}'></script>
<script>
    function format(d) {
        console.log(d);
        return `
            <div>
                <div>Dibuat Oleh : <span class="font-weight-bold">${ d.created_by }</span></div>
                <div>Dibuat Tanggal  : <span class="font-weight-bold">${ d.created_on }</span></div>
                <div>Diupdate Oleh : <span class="font-weight-bold">${ d.updated_by }</span></div>
                <div>Diupdate Tanggal : <span class="font-weight-bold">${ d.updated_on }</span></div>
            </div>
        `;
    }

    var tableId = "#user-table";
    var columns = [
        {
            data: null,
            searchable: false,
            orderable: false
        },
        {
            data: 'npk',
            name: 'npk',
        },
        {
            data: 'role',
            name: 'role'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ];
    url = 'user/json';
</script>
<script src="{{ asset('js/dataTablesAdditionalConfiguration.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $(`${tableId} tbody`).on('click', 'tr .btnDelete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var npk = $(this).data('npk');
        Swal.fire({
            title: 'Apa anda yakin ingin menghapus user dengan npk ' + npk + '?',
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
                    url: `/ajax/user/${id}`,
                    method: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        dt.row($(this).closest('tr')).remove().draw(false);
                        Swal.fire(
                            'Terhapus!',
                            'Data User berhasil dihapus.',
                            'success'
                        )
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal!',
                            'Data User yang dipilih sedang digunakan.',
                            'error'
                        )
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