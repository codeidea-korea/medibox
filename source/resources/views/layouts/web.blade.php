@extends('layouts.base')

@section('title', 'Login')

@section('head')
    <meta charset="utf-8">
    <meta http-equiv="imagetoolbar" content="no">
    <meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
    <link rel="shortcut icon" href="{{ asset('cozyfex/img/favorite/favorite.ico') }}" />
@endsection

@push('base-styles')
    <link rel="stylesheet" href="{{ asset('cozyfex/css/root.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/js/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/js/form/datepicker/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/js/form/myform.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/js/form/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/css/styleDefault.css') }}">
    <link rel="stylesheet" href="{{ asset('cozyfex/css/style.css') }}">
    @stack('styles')
@endpush

@push('base-scripts')
    @stack('top-scripts')

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/animation/easing.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/magnific-popup/jquery.magnific-popup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/dropdown.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/form/bootstrap-select/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/form/bootstrap-select/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/form/datepicker/datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/form/myform.js') }}"></script>
    <script type="text/javascript" src="{{ asset('cozyfex/js/myScript.js') }}"></script>
    <script type="text/javascript">
        $('#main, #view, #wrtie, #background').parent().addClass('bg');

        //location text??????
        $(document).ready(function() {
            var opener_name = $('#header #nav_ul li.open > a').text(),
                page_name = $('#header #nav_ul li.active').text() ? $('#header #nav_ul li.active').text() : '';
            if (typeof opener_name !== typeof undefined && opener_name !== '') {
                $('#topContainer .loaction').append('<span>' + opener_name + '</span>');
            }
            $('#topContainer .loaction').append('<span>' + page_name + '</span>');
        });

        $(function() {
            $('.logout').click(function() {
                $('#logout-form').submit();
                return false;
            });
        });
    </script>
    @stack('scripts')
@endpush

@section('base-content')
    <header id="header">
        <div class="header_container">
            <!--<div class="logo bg"><a href="./index.php">?????? <span>?????????</span></a></div> (????????????..)-->
            <div class="logo">
                <a href="{{ route('admin.index') }}"><img src="{{ asset('cozyfex/img/logo.png') }}"><br />
                    <small>????????? ?????????</small>
                </a>
            </div>
            <nav id="nav">
                <ul id="nav_ul">
                    <li class="@if($currentMenu == 'board_notice') active @endif">
                        <a href="{{ route('admin.index') }}" class="mont">??????</a>
                    </li>
                    <li class="@if($currentMenu == 'board_faq') active @endif">
                        <a href="{{ route('admin.index') }}" class="mont">??????</a>
                    </li>
                    <li class="@if($currentMenu == 'terms') active @endif">
                        <a href="#" class="mont">??????</a>
                        <ul>
                            <li class="@if($currentMenu == 'terms-pick-and-pack-usage') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                            <li class="@if($currentMenu == 'terms-home-usage') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                            <li class="@if($currentMenu == 'terms-marketing') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                            <li class="@if($currentMenu == 'terms-life-care') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                            <li class="@if($currentMenu == 'terms-private') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                            <li class="@if($currentMenu == 'terms-product-usage') active @endif">
                                <a href="{{ route('admin.index') }}">??????</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="wrapper">

        <div id="topContainer">
            <div class="location"></div>
            <ul class="gbMenu">
                <li>
                    <a href="#">??? ?????? ??????</a>
                </li>
                <li>
                    <a href="#">???????????? ??????</a>
                </li>
                <li>
                    <a href="#" class="logout">????????????</a>
                </li>
            </ul>
        </div>

        <form id="logout-form" action="{{ route('admin.logout') }}" method="post">
            @csrf
        </form>

        @yield('content')

        <footer id="footer">
            <div class="footer_container">
                <span class="copyrights">&copy;2021 ADMIN. All Rights Reserved.</span>
            </div>
        </footer>

    </div>
    <!-- //#wrapper -->

    @includeIf('partials.errors')

@endsection
