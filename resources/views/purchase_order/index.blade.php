@extends('master')

@section('title', config('app.name').' | Purchase Order')

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
                        Purchase Order
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class='d-flex justify-content-end my-4'>
                        <a href="{{ url('purchase-order/tambah') }}" class='btn btn-primary'>Tambah Purchase Order</a>
                    </div>
                    <div class="my-2 d-flex justify-content-end">
                            <input type="date" id="start_date" class="form-control col-sm-2">
                            <input type="date" id="end_date" class="form-control col-sm-2 ml-1">
                            <button id="filterButton" class="btn btn-primary ml-1">Filter Tanggal</button>
                        </div>
                    <table class='table' id='purchase-order-table' style="width: 100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>PO</th>
                                <th>Date</th>
                                <th>Vendor</th>
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

    var tableId = "#purchase-order-table";
    var columns = [
        { 
            data: null,
            searchable: false,
            orderable: false 
        },
        {
            data: 'po_number',
            name: 'po_number',
        },
        {
            data: 'date',
            name: 'date'
        },
        {
            data: 'vendor',
            name: 'vendor'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        }
    ];
    url = 'purchase-order/json';

   
</script>
<script src="{{ asset('js/dataTablesAdditionalConfiguration.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    dt.on( 'order.dt search.dt', function () {
        dt.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    }).draw();
</script>
<script>
    var csrf_token = "{{ csrf_token() }}";
    $('#filterButton').click(function() {
        dt.ajax.reload();
    });
</script>
<script src="{{ asset('js/views/purchaseOrderIndex.js') }}"></script>
@endsection