@extends('quicksite::layouts.dashboard')

@section('content')

    <div class="row">
        <h1 class="page-header">Links</h1>
    </div>

    @include('quicksite::modules.links.breadcrumbs', ['location' => [['Menu' => URL::to('quicksite/menus/'.request('m').'/edit')], 'links', 'create']])

    <div class="row">
        {!! Form::open(['route' => 'quicksite.links.store', 'class' => 'add']) !!}

            {!! FormMaker::fromTable('links', Config::get('quicksite.forms.link')) !!}

            <div class="form-group" style="display: none;">
                <label for="Page_id">Page</label>
                <select class="form-control" id="Page_id" name="page_id">
                    @foreach (PageService::getPagesAsOptions() as $key => $value)
                        <option value="{!! $value !!}">{!! $key !!}</option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="menu_id" value="{{ request('m') }}">

            <div class="form-group text-right">
                <a href="{!! URL::previous() !!}" class="btn btn-default raw-left">Cancel</a>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
            </div>

        {!! Form::close() !!}
    </div>
@endsection

@section('javascript')

    @parent
    {!! Minify::javascript(quicksite::asset('js/links-module.js', 'application/javascript')) !!}

@stop
