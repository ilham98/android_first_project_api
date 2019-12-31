<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no"
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <style>
        *,
        *:after,
        *:before {
            margin: 0;
            padding: 0;
        }

        input[type="button"] {
            margin-top: 20px;
        }

        #progress .node {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            transition: all 1000ms ease;
        }

        #progress .activated {
            box-shadow: 0px 0px 3px 2px rgba(194, 255, 194, 0.8);
        }

        #progress .progress-divider {
            height: 40px;
            width: 2px;
            margin-left: 4px;
            transition: all 800ms ease;
        }

        #progress li p {
            display: inline-block;
            margin-left: 25px;
        }

        #progress li {
            list-style: none;
            line-height: 1px;
        }

        #progress p {
            margin-bottom: 0;
        }


        .blue {
            background-color: rgba(82, 165, 255, 1);
        }

        .green {
            background-color: rgba(92, 184, 92, 1)
        }

        .red {
            background-color: rgba(255, 148, 148, 1);
        }

        .grey {
            background-color: rgba(201, 201, 201, 1);
        }

        ul {
            padding: 0;
            margin: 0;
        }

        li {
            padding: 0;
            margin: 0;
        }
    </style>

    @yield('style')
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <img src="{{ asset('images/logo.png') }}" style='width: 80%' alt="">
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>
            <div class="app-header__content">
                <!-- <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                </div> -->
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <button type="button" tabindex="0" class="dropdown-item">User Account</button>
                                            <!-- <h6 tabindex="-1" class="dropdown-header">Header</h6> -->
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <button type="button" tabindex="0" class="dropdown-item" onclick="logout()">Logout</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{ Auth::user()->karyawan->nama }}
                                    </div>
                                    <div class="widget-subheading">
                                        @if(Auth::user())
                                            {{ Auth::user()->role->nama }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui-theme-settings">
        </div>
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <div class="logo-src"></div>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>
                <div class="scrollbar-sidebar">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu mt-3">
                            <li>
                                <a href="{{ url('/') }}" class="{{ url('/') == url()->current() ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-display1"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Master Data</li>
                            <li>
                                <a href="{{ url('/user') }}" class="{{ url('/user') == url()->current() ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-users"></i>
                                    User
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/vendor') }}" class="{{ url('/vendor') == url()->current() ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-id">
                                    </i>Vendor
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/software') }}" class="{{ url('/software') == url()->current() ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-tools">
                                    </i>Software
                                </a>
                            </li>
                            <li class="app-sidebar__heading">Transaction</li>
                            <li>
                                <a href="{{ url('/purchase-order') }}" class="{{ url('/purchase-order') == url()->current() ? 'mm-active' : '' }}">
                                <i class="metismenu-icon pe-7s-note2"></i>
                                    </i>Purchase Order
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('aset') }}" class="{{ (
                                    Request::is('aset') || 
                                    Request::is('aset/*')
                                ) ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-phone"></i>
                                    Aset
                                </a>
                            </li>   
                            <li>
                                <a href="{{ url('permintaan-pengeluaran-barang') }}" class="{{ (
                                    Request::is('permintaan-pengeluaran-barang') || 
                                    Request::is('permintaan-pengeluaran-barang/*')
                                ) ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-mail-open-file"></i>
                                    P. Pengeluaran Barang
                                </a>
                            </li>                         
                            <li class="app-sidebar__heading">Report</li>
                            <li>
                                <a href="{{ url('report/aset') }}" class="{{ (Request::is('report/aset') || Request::is('report/aset/*')) ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-copy-file"></i>
                                    Aset
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('report/purchase-order') }}" class="{{ (Request::is('report/purchase-order') || Request::is('report/purchase-order/*')) ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-copy-file"></i>
                                    Purchase Order
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('report/pengeluaran-barang') }}" class="{{ (Request::is('report/pengeluaran-barang') || Request::is('report/pengeluaran-barang/*')) ? 'mm-active' : '' }}">
                                    <i class="metismenu-icon pe-7s-copy-file"></i>
                                    Pengeluaran Barang
                                </a>
                            </li>
                    </div>
                </div>
            </div>
            @yield('content')
            <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        </div>
        @yield('extra')
    </div>
    
    
    <script type="text/javascript" src="/scripts/main.js"></script>
    <script>
        function logout() {
            window.location.href = `{{ url('/logout') }}`; 
        }
    </script>
    @yield('script')
</body>

</html>