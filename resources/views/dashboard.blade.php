@extends('master')

@section('style')
<link rel="stylesheet" type="text/css" href='{{ asset("css/dashboard.css") }}'>
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
                            Riwayat Aktivitas
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container mt-5 mb-5">
                            <div class="row">
                                <div class="col-md-6 offset-md-3">
                                    <ul class="timeline">
                                        <li>
                                            <a target="_blank" href="https://www.totoprayogo.com/#">New Web Design</a>
                                            <a href="#" class="float-right">21 March, 2014</a>
                                        </li>
                                        <li>
                                            <a href="#">21 000 Job Seekers</a>
                                            <a href="#" class="float-right">4 March, 2014</a>
                                            <p>Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
                                        </li>
                                        <li>
                                            <a href="#">Awesome Employers</a>
                                            <a href="#" class="float-right">1 April, 2014</a>
                                            <p>Fusce ullamcorper ligula sit amet quam accumsan aliquet. Sed nulla odio, tincidunt vitae nunc vitae, mollis pharetra velit. Sed nec tempor nibh...</p>
                                        </li>
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