@extends('master')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/selectize.css') }}" />
<style>
    .jquery-validate-error-message {
        color: red;
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
                                    <input type="text" id="no_surat" class="form-control" name="no_surat">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Departemen</label>
                                    <select class="form-control" name="departemen" id="departemen"></select>
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
                            <div class="form-group col-md-6">
                                <input type='submit' class='btn btn-primary' value='Tambah Aset'>
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
                                    <th>Item</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="tableTbody"> 
                                
                            </tbody>
                        </table>
                        <div class="form-group">
                            <button type="text" id="btnSave" class="btn btn-primary">Simpan</button>
                        </div>
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
    var csrf_token = "{{ csrf_token() }}"
</script>
<script src="{{ asset('js/views/permintaanPengeluaranBarangCreate.js') }}"></script>

@endsection