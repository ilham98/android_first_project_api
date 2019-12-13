@extends('master')

@section('style')
    <link rel="stylesheet" type="text/css" href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>
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
                                            Vendor
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ url('vendor') }}" class='col-sm-6' method='POST'>
                                            <div class='form-group'>
                                                <label>Nama Vendor</label>
                                                <input type="text" name='nama' value='{{ old("nama") }}' class='form-control'>
                                                @if($errors->has('nama'))
                                                    <p class="text-danger">{{ $errors->first('nama') }}</p>
                                                @endif
                                            </div>
                                            <div class='form-group'>
                                                <label>Contact Person</label>
                                                <input type="text" name='contact_person' value='{{ old("contact_person") }}' class='form-control'>
                                                @if($errors->has('contact_person'))
                                                    <p class="text-danger">{{ $errors->first('contact_person') }}</p>
                                                @endif
                                            </div>
                                            <div class='form-group'>
                                                <input type="submit" value='Update' class='btn btn-primary'>
                                            </div>
                                            @csrf
                                            @method('POST')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection