@extends('quicksite::layouts.navigation')

@section('page-content')

    <div class="overlay"></div>

    {!! Minify::stylesheet(Quicksite::asset('css/dashboard.css', 'text/css')) !!}

    <div class="row raw-margin-top-50">
        <div class="col-md-12">
            @yield('content')
        </div>
    </div>

    <div class="raw100 raw-left navbar navbar-fixed-bottom">
        <div class="raw100 raw-left quicksite-footer">
            <p class="raw-margin-left-20">Brought to you by: <a href="https://twitter.com/sirdom__">Ayimdomnic</a></p>
        </div>
    </div>
@stop
