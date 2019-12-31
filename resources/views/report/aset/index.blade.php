
@extends('master')

@section('title', config('app.name').' | Report Aset')

@section('style')
<link rel="stylesheet" type="text/css" href="/css/jquery.transfer.icon.css" />
<link rel="stylesheet" type="text/css" href="/css/jquery.transfer.css?v=0.0.2" />
<style>
    .jquery-validate-error-message {
        color: red;
    }

    .transfer-double-content-left, .transfer-double-content-right {
        width: 45%;
    }

    .transfer-double {
        width: 100%;
        box-shadow: none;
        border: none;
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
                            Aset
                        </div>
                    </div>
                    <div class="card-body">
                    <div>
                        <div id="transfer" class="transfer-demo"></div>
                        <form action="{{ '/report/aset/download' }}" class="px-4" id="form" method="POST">
                            <div class="form-group">
                                <label>Filter Berdasarkan</label>
                                <select type="text" name="filterByDate" class="form-control col-sm-3">
                                    <option value="">Pilih Kolom</option>
                                    <option value="tr_aset.created_on">Created On</option>
                                    <option value="kasie_layanan_in_on">Kasie Layanan In On</option>
                                    <option value="teknisi_in_on">Teknisi In On</option>
                                    <option value="kontrol_aset_in_on">Kontrol Aset In On</option>
                                    <option value="kabag_layanan_in_on">Kabag Layanan In On</option>
                                    <option value="approved_by_kabag_layanan_on">Approved by Kabag Layanan On</option>
                                    <option value="rejected_by_kabag_layanan_on">Rejected by Kabag Layanan On</option>
                                    <option value="approved_by_kepala_unit_kerja_on">Approved By Kepala Unit Kerja On</option>
                                    <option value="barang_diserahkan_ke_pengguna_on">Barang Diserahkan Ke Pengguna On</option>
                                </select>
                                <div class="row mt-3">
                                    <div class="form-group col-sm-3">
                                        <label>Dari</label>
                                        <input name="from" type="date" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label>Hingga</label>
                                        <input name="to" type="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            @csrf
                            @method('POST')
                            <div hidden id="selected-fields">

                            </div>
                        </form>
                        <div class='d-flex justify-content-end'>
                            <button class="btn btn-primary" id="btnCetak">Cetak</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.transfer.js?v=0.0.3"></script>
<script type="text/javascript">
    var dataArray1 = @json($asetColumn);

    var settings = {
        "dataArray": dataArray1,
        "itemName": "column",
        "valueName": "value",
        "callable": function (items) {
            console.dir(items)
        }
    };

    $('#btnCetak').click(function(e) {
        var items = transfer.getSelectedItems();
        e.preventDefault();

        if(items.length == 0) {
            return ;
        } 

        $('#selected-fields').html(``);
        
        items.forEach(function(i) {
            $('#selected-fields').append(`
                <input hidden name='column[]' value='${i.column}' />
            `);
        });

        $('#form').submit();
        
    });

    var transfer = $("#transfer").transfer(settings);
    
    
</script>
@endsection