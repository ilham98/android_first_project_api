@extends('master')

@section('style')
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
                            Tambah User
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="userForm" action="{{ url('user') }}" class='col-sm-6' method='POST'>
                            <div class='form-group'>
                                <label>NPK</label>
                                <input type="text" name='npk' value='{{ old("npk") }}' class='form-control'>
                            </div>
                            @if($errors->has('npk'))
                            <p class='text-danger'>{{ $errors->first('npk') }}</p>
                            @endif
                            <div class='form-group'>
                                <label>Role</label>
                                <select name='role_id' id="role_id" class='form-control'>
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $r)
                                    <option {{ old('role_id') == $r->id ? 'selected' : '' }} value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($errors->has('role_id'))
                                <p class='text-danger'>{{ $errors->first('role_id') }}</p>
                            @endif
                            <div class="form-group" id="departemen_container">
                                <label>Departemen</label>
                                <select class="form-control" name="departemen_id" id="departemen_id"></select>
                                @if($errors->has('departemen_id'))
                                    <p class='text-danger'>{{ $errors->first('departemen_id') }}</p>
                                @endif
                            </div>
                            @csrf
                            @method('POST')
                            <div class='form-group'>
                                <input type='submit' class='btn btn-primary' value='Tambah User'>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('extra')
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('js/jqueryValidation.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $('#departemen_id').select2({
        ajax: {
            url: '/ajax/departemen',
            dataType: 'json',
            type: 'GET',
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            text: item.nama
                        }
                    })
                }
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });

    $('#departemen_container').hide();
    @if(old('role_id') == 6)
        $('#departemen_container').show();
    @endif

    $('#role_id').change(function() {
        var val = $(this).val();
        $('#departemen_container').hide();
        if(val == 6)
            $('#departemen_container').show();
            
    });
</script>
@endsection