@extends('master')

@section('title', config('app.name').' | Edit P. Pengeluaran')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/selectize.css') }}" />
<style>
    .jquery-validate-error-message {
        color: red;
    }

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
                            Tambah Permintaan Pengeluaran Barang
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('permintaan-pengeluaran-barang') }}" id="permintaanPengeluaranBarangForm" method='POST'>
                            <div class="col h6">Permintaan Pengeluaran Barang</div>
                            <hr>
                            <div class="row col">
                                <div class="form-group col-md-6">
                                    <label>Nomor Surat</label>
                                    <input type="text" id="no_surat" value="{{ $p_barang->no_surat }}" class="form-control" name="no_surat">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Departemen</label>
                                    <select class="form-control" name="departemen" id="departemen">
                                        <option value="{{ $p_barang->kode_unit_kerja }}">{{ $p_barang->unit_kerja->UnitKerja }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                            
                            <div class="col h6 mt-3">Item Details</div>
                            <hr>
                            <!-- <div class="form-group col-md-6">
                                <label>Tipe</label>
                                <select name="tipe" id="tipe" class="form-control">
                                    <option value="">Pilih Tipe Barang</option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-6">
                                <label>Purchase Order</label>
                                <select class="form-control" name="po_number" id="po_number"></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Item</label>
                                <select class="form-control" name="item" id="item"></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="">Pilih Status</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="peminjamanContainer" style="display: none">
                                <div class="form-group col-md-6">
                                    <label>Tanggal Mulai Peminjaman</label>
                                    <input type="date" id="peminjaman_start_date" name="peminjaman_start_date" class="form-control" />
                                </div> 
                                <div class="form-group col-md-6">
                                    <label>Tanggal Selesai Peminjaman</label>
                                    <input type="date" id="peminjaman_end_date" name="peminjaman_end_date" class="form-control" />
                                </div> 
                            </div>
                            <div class="form-group col-md-6">
                            <input type='submit' class='btn btn-primary' value='Tambah Aset' id="buttonTambahAset">
                                <input type='submit' class='btn btn-primary' id="buttonUpdateAset" style="display: none" value='Update Aset'>
                            </div>
                            @csrf
                            @method('POST')
                        </form>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>PO</th>
                                    <th>R. Number</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tableTbody"> 
                                @foreach($aset as $index => $a)
                                    <tr data-id="{{ $a->id }}">
                                        <td></td>
                                        <td class='tableItemTipeNama'>{{ $a->tipe->nama }}</td>
                                        <td class='tablePoNumber'>{{ $a->item->purchase_order->po_number }}</td>
                                        <td class='tableRegistrationNumber'>{{ $a->registration_number }}</td>
                                        <td class='tableItem'>{{ $a->item->nama }}</td>
                                        <td class='tableStatus'>{{ $a->status_pengeluaran_barang->nama }}</td>
                                        <td>
                                            <span class="btnEdit"><i class="pe-7s-pen  text-success"></i></span>
                                            <span class="btnDelete"><i class="pe-7s-trash  text-danger"></i></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/selectize.js') }}"></script>
<script src="{{ asset('js/jqueryValidation.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    var permintaanPengeluaranBarangItemsEdit = [];
</script>
<script>
    var csrf_token = "{{ csrf_token() }}";
    var fromEditForm = true;
    var permintaan_pengeluaran_barang_id = {!! $p_barang->id !!};
</script>
<script src="{{ asset('js/views/permintaanPengeluaranBarangCreate.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    $('body table').on('click', '.btnDelete', function() {
        var tr = $(this).closest('tr');
        var currentId = tr.data('id');
        Swal.fire({
            title: 'Hapus Aset?',
            text: "Apa anda yakin ingin menghapus aset.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: `/ajax/permintaan-pengeluaran-barang/{!! $p_barang->id !!}/aset/${currentId}`,
                    method: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        permintaanPengeluaranBarangItems = permintaanPengeluaranBarangItems.filter(function(p) {
                            p !== currentId;
                        });
                        tr.remove();
                        Swal.fire(
                            'Terhapus!',
                            'Data User berhasil dihapus.',
                            'success'
                        )
                    },
                    error: function(err) {
                        Swal.fire(
                            'Gagal Menghapus!',
                            'Data aset yang dipilih sudah masuk kepada teknisi.',
                            'error'
                        )
                    }
                })
            }
        });
        
    });
</script>
@endsection