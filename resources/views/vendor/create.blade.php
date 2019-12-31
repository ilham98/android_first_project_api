@extends('master')

@section('title', config('app.name').' | Tambah Vendor')

@section('style')
    <link rel="stylesheet" type="text/css" href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>
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
                                                <label>No Telepon</label>
                                                <input type="text" name='no_telepon' value='{{ old("no_telepon") }}' class='form-control'>
                                                @if($errors->has('no_telepon'))
                                                    <p class="text-danger">{{ $errors->first('no_telepon') }}</p>
                                                @endif
                                            </div>
                                            <div class='form-group'>
                                                <label>Email</label>
                                                <input type="text" name='email' value='{{ old("email") }}' class='form-control'>
                                                @if($errors->has('email'))
                                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>
                                            <div class='form-group'>
                                                <input type="submit" value='Tambah' class='btn btn-primary'>
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