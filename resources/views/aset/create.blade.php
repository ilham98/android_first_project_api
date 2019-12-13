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
        <div class="app-page-title">
            <div class="page-title-wrapper">

                <div class="page-title-actions">
                    <button type="button" data-toggle="tooltip" title="Example Tooltip" data-placement="bottom" class="btn-shadow mr-3 btn btn-dark">
                        <i class="fa fa-star"></i>
                    </button>
                    <div class="d-inline-block dropdown">
                        <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn-shadow dropdown-toggle btn btn-info">
                            <span class="btn-icon-wrapper pr-2 opacity-7">
                                <i class="fa fa-business-time fa-w-20"></i>
                            </span>
                            Buttons
                        </button>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-inbox"></i>
                                        <span>
                                            Inbox
                                        </span>
                                        <div class="ml-auto badge badge-pill badge-secondary">86</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-book"></i>
                                        <span>
                                            Book
                                        </span>
                                        <div class="ml-auto badge badge-pill badge-danger">5</div>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0);" class="nav-link">
                                        <i class="nav-link-icon lnr-picture"></i>
                                        <span>
                                            Picture
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a disabled href="javascript:void(0);" class="nav-link disabled">
                                        <i class="nav-link-icon lnr-file-empty"></i>
                                        <span>
                                            File Disabled
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <form action="{{ url('aset') }}" id="asetForm" method='POST'>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Registration Number</label>
                                        <input type="text" id="registration_number" class="form-control" value="{{ old('registration_number') }}" name="registration_number">
                                    </div>
                                    <div class="form-group">
                                        <label>PO Number</label>
                                        <select class="form-control" type="text" id="po_number" name="po_number">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Item</label>
                                        <select  class="form-control" id="item" name="item"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select id="tipe" class="form-control" name="tipe">
                                            <option value="">Pilih Tipe</option>
                                            @foreach($tipe as $t)
                                                <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select id="status" class="form-control" name="status">
                                            <option value="">Pilih Status</option>
                                            @foreach($status as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departemen</label>
                                        <select class="form-control" name="departemen" id="departemen"></select>
                                    </div>
                                    <div class="form-group">
                                        <label>User</label>
                                        <select class="form-control" name="user" id="user"></select>
                                    </div>
                                </div>
                            </div>
                            @csrf
                            @method('POST')
                            <div class='form-group'>
                                <input type='submit' class='btn btn-primary' value='Tambah Aset'>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/selectize.js') }}"></script>
<script src="{{ asset('js/jqueryValidation.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="{{ asset('js/views/asetCreate.js') }}"></script>
<script>

</script>

@endsection