@extends('master')

@section('title', config('app.name').' | P. Pengeluaran')

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
                            <!-- <button class="btn btn-primary" id="btnImport">Import File Excel</button> -->
                            <a class="btn btn-primary" href="{{ url()->current().'/tambah' }}">Tambah Permintaan Pengeluaran Barang</a>
                        </div>
                        <table class='table' id='pengeluaran-barang-table' style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat</th>
                                    <th>Department</th>
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
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src='{{ asset('js/dataTables.js') }}'></script>
<script src='{{ asset('js/dataTablesBootstrap4.js') }}'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ];
    url = 'permintaan-pengeluaran-barang/json';
    var csrf_token = '{!! csrf_token() !!}';
</script>
<script src="{{ asset('js/dataTablesAdditionalConfiguration.js') }}"></script>
<script>
    dt.on('order.dt search.dt', function() {
        dt.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
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
            title: 'Hapus Permintaan Pengeluaran Barang?',
            text: `Apa anda yakin ingin menghapus permintaan pengeluaran barang ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/ajax/permintaan-pengeluaran-barang/${id}`,
                    method: 'DELETE',
                    data: {
                        "_token": csrf_token
                    },
                    success: function(res) {
                        dt.row($(this).closest('tr')).remove().draw(false);
                        Swal.fire(
                            'Terhapus!',
                            'Data Permintaan Pengeluaran Barang berhasil dihapus.',
                            'success'
                        )
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal menghapus!',
                            'Penghapusan Data Permintaan Pengeluaran Barang gagal.',
                            'error'
                        )
                    }
                })
            }
        })
    })
</script>
@endsection