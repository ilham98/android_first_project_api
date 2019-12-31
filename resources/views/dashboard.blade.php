@extends('master')

@section('title', config('app.name').' | Dashboard')

@section('style')
<link rel="stylesheet" type="text/css" href='{{ asset("css/dashboard.css") }}'>
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
                            Dashboard
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="search-container">
                                        <img class="search" src="{{ asset('svg/search.svg') }}" alt="">
                                        <div class="search-text">
                                            <div>Tracking</div>
                                            <div>Aset</div>
                                        </div>
                                    </div>
                                    
                                    <select type="text" id="aset" class="form-control">
                                        <option value="">Silahkan Pilih Aset</option>
                                    </select>
                                    <ul class="timeline" id="timeline">
                                        
                                    </ul>
                                </div>
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
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#aset').select2({
            ajax: {
            url: '/ajax/aset',
            dataType: 'json',
            type: 'GET',
            processResults: function (data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id,
                            text: item.registration_number
                        }
                    })
                }
            }
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            }
        });

        function getMonth(id) {
            switch(id) {
                case 1:
                    return 'Januari';
                case 2:
                    return 'Februari';
                case 3:
                    return 'Maret';
                case 4:
                    return 'April';
                case 5:
                    return 'Mei';
                case 6:
                    return 'Juni';
                case 7:
                    return 'Juli';
                case 8:
                    return 'Agustus';
                case 9:
                    return 'September';
                case 10:
                    return 'Oktober';
                case 11:
                    return 'November';
                case 12:
                    return 'Desember';
            } 
        }

        $('#aset').on('select2:select', function (e) {
            var id = e.params.data.id;
            $('#timeline').html('');
            $.ajax({
                method: 'GET',
                url: '/tracking-aset/' + id,
                success: function(res) {
                    res.forEach(function(d) {
                        var newDate = new Date(d.created_on);
                        console.log(newDate);
                        $('#timeline').append(`
                            <li>
                                <a href="#">${ d.title }</a>
                                <a href="#" class="float-right">${ newDate.getHours() }:${ newDate.getMinutes() <= 9 ? "0" + newDate.getMinutes() : newDate.getMinutes()  }, ${ newDate.getDate() } ${ getMonth(newDate.getMonth()) } ${ newDate.getFullYear() }</a>
                                <p>${ d.body }</p>
                            </li>
                        `);
                    } )  
                },
                error: function(err) {
                    $('#timeline').html('');
                }
            })
        });
    </script>
@endsection