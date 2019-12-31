@extends('master')

@section('title', config('app.name').' | Tambah User')

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
                            <div class="form-group">
                                <label>Departemen</label>
                                <select class="form-control" name="departemen" id="departemen"></select>
                            </div>
                            <div class="form-group">
                                <label>User</label>
                                <select disabled class="form-control" name="npk" id="user"></select>
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
      $('#departemen').select2({
        ajax: {
        url: '/ajax/departemen',
        dataType: 'json',
        type: 'GET',
    
        processResults: function (data) {
            return {
                results: $.map(data, function(item) {
                    return {
                        id: item.KodeUnitKerja,
                        text: item.UnitKerja
                    }
                })
            }
        }
        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
  });

  $('#departemen').on('select2:select', function (e) {
    $('#user').val(null).trigger('change');
    var data = e.params.data;

    $('#user').removeAttr('disabled');
});

  $('#user').select2({
    ajax: {
      url: '/ajax/karyawan',
      dataType: 'json',
      type: 'GET',
      data: function(data) {
        return {
          q: data.term,
          kode_unit_kerja: $("#departemen").val()
        }  
      },
      processResults: function (data) {
          return {
              results: $.map(data, function(item) {
                return {
                    id: item.npk,
                    text: item.nama
                }
              })
          }
      }
      // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
    }
  });
</script>
@endsection